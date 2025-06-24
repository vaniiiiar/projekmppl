<?php

namespace App\Filament\Admin\Resources;

use App\Exports\PaymentReportExport;
use App\Filament\Admin\Resources\PaymentResource\Pages;
use App\Models\Order;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Number;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $modelLabel = 'Payment';

    protected static ?string $navigationGroup = 'Transactions';

    protected static ?int $navigationSort = 4;

    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payment Information')
                    ->schema([
                        Forms\Components\Select::make('order_id')
                            ->label('Order')
                            ->relationship(
                                name: 'order',
                                titleAttribute: 'id',
                                modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('payment')
                                    ->where('transaction_status', 'confirmed')
                            )
                            ->getOptionLabelFromRecordUsing(fn (Order $record) => "Order #{$record->id} - {$record->user->name} - " . Number::currency($record->total_price, 'IDR'))
                            ->required()
                            ->searchable(['id', 'user.name'])
                            ->preload()
                            ->disabledOn('edit'),
                            
                        Forms\Components\TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(1)
                            ->default(function ($get) {
                                if ($orderId = $get('order_id')) {
                                    $order = Order::find($orderId);
                                    return $order ? $order->total_price : 0;
                                }
                                return 0;
                            }),
                            
                        Forms\Components\Select::make('method')
                            ->options([
                                'cash' => 'Cash',
                                'credit_card' => 'Credit Card',
                                'debit_card' => 'Debit Card', 
                                'e-wallet' => 'E-Wallet',
                                'qris' => 'QRIS',
                            ])
                            ->required()
                            ->native(false),
                            
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'completed' => 'Completed',
                                'failed' => 'Failed',
                                'refunded' => 'Refunded',
                            ])
                            ->required()
                            ->native(false),
                            
                        Forms\Components\TextInput::make('transaction_id')
                            ->label('Transaction ID/Reference')
                            ->maxLength(255),
                            
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Payment Date/Time')
                            ->default(now())
                            ->displayFormat('d M Y H:i')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['order.user', 'order.product']))
            ->columns([
                Tables\Columns\TextColumn::make('order.id')
                    ->label('Order ID')
                    ->formatStateUsing(fn ($state) => "#{$state}")
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => OrderResource::getUrl('edit', [$record->order_id])),
                    
                Tables\Columns\TextColumn::make('order.user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable()
                    ->description(fn ($record) => "Subtotal: " . Number::currency($record->order->subtotal, 'IDR') . " | Tax: " . Number::currency($record->order->tax, 'IDR')),
                    
                Tables\Columns\BadgeColumn::make('method')
                    ->colors([
                        'success' => 'cash',
                        'primary' => 'credit_card',
                        'secondary' => 'debit_card',
                        'warning' => 'e-wallet',
                        'info' => 'qris',
                    ])
                    ->formatStateUsing(fn ($state) => ucwords(str_replace('_', ' ', $state))),
                    
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'completed',
                        'danger' => 'failed',
                        'info' => 'refunded',
                    ])
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Payment Time')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('Transaction Ref')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                    
                Tables\Columns\TextColumn::make('order.order_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'dine_in' => 'success',
                        'take_away' => 'warning',
                    })
                    ->formatStateUsing(fn ($state) => strtoupper(str_replace('_', ' ', $state)))
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('method')
                    ->options([
                        'cash' => 'Cash',
                        'credit_card' => 'Credit Card',
                        'debit_card' => 'Debit Card',
                        'e-wallet' => 'E-Wallet',
                        'qris' => 'QRIS',
                    ]),
                    
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ]),
                    
                Tables\Filters\SelectFilter::make('order.order_type')
                    ->label('Order Type')
                    ->options([
                        'dine_in' => 'Dine In',
                        'take_away' => 'Take Away',
                    ]),
                    
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('paid_from'),
                        Forms\Components\DatePicker::make('paid_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['paid_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['paid_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->headerActions([
                Tables\Actions\Action::make('total_income')
                    ->label('Total Income')
                    ->modalHeading('Income Summary')
                    ->modalDescription(function (Tables\Table $table) {
                        $query = static::getEloquentQuery();
                        foreach ($table->getFilters() as $filter) {
                            $filter->applyToBaseQuery($query);
                        }
                        
                        $total = $query->sum('amount');
                        $count = $query->count();
                        $completed = $query->clone()->where('status', 'completed')->count();
                        $pending = $query->clone()->where('status', 'pending')->count();
                        
                        return "
                            <div class='space-y-2'>
                                <p><strong>Total Payments:</strong> " . Number::currency($total, 'IDR') . "</p>
                                <p><strong>Total Transactions:</strong> {$count}</p>
                                <p><strong>Completed Payments:</strong> {$completed}</p>
                                <p><strong>Pending Payments:</strong> {$pending}</p>
                            </div>
                        ";
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->color('success')
                    ->icon('heroicon-o-chart-bar'),
                
                Tables\Actions\Action::make('exportSalesReport')
                    ->label('Export Sales Report')
                    ->color('primary')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->form([
                        Forms\Components\Select::make('type')
                            ->options([
                                'monthly' => 'Monthly',
                                'custom' => 'Custom Period',
                            ])
                            ->default('monthly')
                            ->live()
                            ->label('Export Type'),
                        
                        Forms\Components\Select::make('month')
                            ->options([
                                '1' => 'January', '2' => 'February', '3' => 'March',
                                '4' => 'April', '5' => 'May', '6' => 'June',
                                '7' => 'July', '8' => 'August', '9' => 'September',
                                '10' => 'October', '11' => 'November', '12' => 'December',
                            ])
                            ->default(now()->month)
                            ->label('Month')
                            ->visible(fn (Forms\Get $get) => $get('type') === 'monthly'),
                        
                        Forms\Components\Select::make('year')
                            ->options(function() {
                                $years = [];
                                for ($i = 2020; $i <= now()->year; $i++) {
                                    $years[$i] = $i;
                                }
                                return $years;
                            })
                            ->default(now()->year)
                            ->label('Year')
                            ->visible(fn (Forms\Get $get) => $get('type') === 'monthly'),
                        
                        Forms\Components\DatePicker::make('start_date')
                            ->label('From Date')
                            ->default(now()->startOfMonth())
                            ->visible(fn (Forms\Get $get) => $get('type') === 'custom'),
                        
                        Forms\Components\DatePicker::make('end_date')
                            ->label('To Date')
                            ->default(now()->endOfMonth())
                            ->visible(fn (Forms\Get $get) => $get('type') === 'custom'),
                    ])
                    ->action(function (array $data) {
                        $fileName = $data['type'] === 'monthly' 
                            ? 'sales-report-' . $data['month'] . '-' . $data['year'] . '.xlsx'
                            : 'sales-report-' . $data['start_date']->format('Y-m-d') . '-to-' . $data['end_date']->format('Y-m-d') . '.xlsx';

                        if ($data['type'] === 'monthly') {
                            $startDate = \Carbon\Carbon::create($data['year'], $data['month'], 1)->startOfMonth();
                            $endDate = $startDate->copy()->endOfMonth();
                        } else {
                            $startDate = $data['start_date'];
                            $endDate = $data['end_date'];
                        }

                        return Excel::download(
                            new PaymentReportExport($startDate, $endDate),
                            $fileName
                        );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // You could add relation managers here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}