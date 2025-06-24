<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $modelLabel = 'My Orders';
    protected static ?string $navigationLabel = 'My Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Information')
                    ->schema([
                        // Product selection
                        Forms\Components\Select::make('product_id')
                        ->label('Pilih Produk')
                        ->relationship('product', 'name')
                        ->searchable()
                        ->preload()
                        ->required() // WAJIB ADA
                        ->live()
                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                            if ($state) {
                                $product = Product::find($state);
                                $set('subtotal', $product->price);
                                $set('tax', $product->price * 0.05);
                                $set('total_price', $product->price * 1.05);
                            }
                        }),
                            
                        // Order type
                        Forms\Components\Select::make('order_type')
                            ->options([
                                'dine_in' => 'Dine In',
                                'take_away' => 'Take Away',
                            ])
                            ->required()
                            ->live()
                            ->native(false),
                            
                        // Table number (only visible for dine_in)
                        Forms\Components\TextInput::make('table_number')
                            ->numeric()
                            ->nullable()
                            ->visible(fn (Forms\Get $get): bool => $get('order_type') === 'dine_in'),
                            
                        // Auto-calculated prices (hidden)
                        Forms\Components\Hidden::make('user_id')
                            ->default(Auth::id()),
                        Forms\Components\Hidden::make('subtotal'),
                        Forms\Components\Hidden::make('tax'),
                        Forms\Components\Hidden::make('total_price'),
                        Forms\Components\Hidden::make('status')
                            ->default('pending'),
                        Forms\Components\Hidden::make('transaction_status')
                            ->default('pending'),
                    ]),

                     Forms\Components\Section::make('Pembayaran')
                            ->visible(fn ($record) => $record && $record->status === 'pending')
                            ->schema([
                                Forms\Components\Actions::make([
                                    Forms\Components\Actions\Action::make('payNow')
                                        ->label('Bayar Sekarang')
                                        ->url(fn ($record) => static::getUrl('payment', ['record' => $record->id]))
                                        ->button()
                                        ->color('success')
                                        ->icon('heroicon-o-credit-card'),
                                ]),
                            ]),
                    
                // Price summary section
                Forms\Components\Section::make('Price Summary')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\TextInput::make('tax')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\TextInput::make('total_price')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', Auth::id()))
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('order_type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'dine_in' => 'Dine In',
                        'take_away' => 'Take Away',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'dine_in' => 'info',
                        'take_away' => 'warning',
                    }),
                    
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'acc' => 'success',
                        'processing' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    }),
                    
                Tables\Columns\TextColumn::make('total_price')
                    ->money('IDR')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('cancel')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->action(fn (Order $record) => $record->update(['status' => 'cancelled']))
                    ->visible(fn (Order $record): bool => $record->status === 'pending'),
                 // Add print receipt action for confirmed bookings
                Tables\Actions\Action::make('printReceipt')
    ->label('Cetak Struk')
    ->icon('heroicon-o-printer')
    ->color('success')
    ->visible(fn ($record) => $record->status === 'acc')
    ->url(fn ($record) => route('filament.customer.resources.orders.print-receipt', ['record' => $record]))
    ->openUrlInNewTab(),
            ])
            ->bulkActions([])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Place New Order'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'payment' => Pages\PaymentOrder::route('/{record}/payment'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'print-receipt' => Pages\PrintReceipt::route('/{record}/print-receipt'),
        ];
    }

    public static function canEdit($record): bool
    {
        return false;
    }
}