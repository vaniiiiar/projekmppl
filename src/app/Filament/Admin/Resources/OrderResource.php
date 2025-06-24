<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $modelLabel = 'Orders';
    protected static ?string $navigationLabel = 'Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                            
                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                            
                        Forms\Components\Select::make('order_type')
                            ->options([
                                'dine_in' => 'Dine In',
                                'take_away' => 'Take Away',
                            ])
                            ->required(),
                            
                        Forms\Components\TextInput::make('table_number')
                            ->numeric()
                            ->nullable()
                            ->visible(fn (Forms\Get $get): bool => $get('order_type') === 'dine_in'),
                            
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'acc' => 'Accept',
                                'decline' => 'Cancelled',
                            ])
                            ->required(),
                            
                        Forms\Components\Select::make('transaction_status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                            ])
                            ->required(),
                            
                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->required(),
                            
                        Forms\Components\TextInput::make('tax')
                            ->numeric()
                            ->required(),
                            
                        Forms\Components\TextInput::make('total_price')
                            ->numeric()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),
                    
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
                        'acc' => 'Proccessing',
                        'processing' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    }),
                    
                Tables\Columns\TextColumn::make('transaction_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'failed' => 'danger',
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
                        'acc' => 'Proccessing',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                    
                Tables\Filters\SelectFilter::make('transaction_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ]),
                    
                Tables\Filters\SelectFilter::make('order_type')
                    ->options([
                        'dine_in' => 'Dine In',
                        'take_away' => 'Take Away',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                
                // ✅ Payment Verification Action (Fixed SQL Error)
                Tables\Actions\Action::make('verifyPayment')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Order $record) {
                        if ($record->payment) {
                            $record->payment->update(['status' => 'completed']); // ✅ Fixed: 'paid' is now properly quoted
                            $record->update(['transaction_status' => 'paid']);
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Payment Verified Successfully')
                                ->success()
                                ->send();
                        }
                    })
                    ->visible(fn (Order $record): bool => 
                        $record->payment && 
                        $record->payment->status === 'pending' && 
                        $record->transaction_status === 'pending'
                    ),
                    
                // Mark as Completed
                Tables\Actions\Action::make('markCompleted')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->action(function (Order $record) {
                        $record->update(['status' => 'completed']);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Order Marked as Completed')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Order $record): bool => 
                        $record->status !== 'completed' && 
                        $record->status !== 'cancelled' && 
                        $record->transaction_status === 'paid'
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PaymentRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}