<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderItemResource\Pages;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $modelLabel = 'Order Item';

    protected static ?string $navigationGroup = 'Transactions';

    protected static ?int $navigationSort = 3;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->label('Order')
                    ->relationship('order', 'order_code')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($product = Product::find($state)) {
                            $set('unit_price', $product->base_price);
                        }
                    }),

                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->minValue(1),

                Forms\Components\TextInput::make('unit_price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),

                Forms\Components\Select::make('size')
                    ->options(function (Forms\Get $get) {
                        if ($product = Product::find($get('product_id'))) {
                            return $product->size_prices ? array_combine(
                                array_keys($product->size_prices),
                                array_keys($product->size_prices)
                            ) : null;
                        }
                        return null;
                    })
                    ->visible(fn (Forms\Get $get) => Product::find($get('product_id'))?->has_size ?? false)
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Get $get, Forms\Set $set) {
                        if ($product = Product::find($get('product_id'))) {
                            $sizePrices = $product->size_prices;
                            if ($sizePrices && isset($sizePrices[$state])) {
                                $set('unit_price', $sizePrices[$state]);
                            }
                        }
                    }),

                Forms\Components\TagsInput::make('customizations')
                    ->columnSpanFull()
                    ->placeholder('Add customizations (e.g., less sugar, extra shot)'),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.order_code')
                    ->label('Order Code')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => OrderResource::getUrl('edit', [$record->order_id])),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('unit_price')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('size')
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->getStateUsing(fn ($record) => $record->quantity * $record->unit_price)
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added At')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('order')
                    ->relationship('order', 'order_code')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('product')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderItems::route('/'),
            'create' => Pages\CreateOrderItem::route('/create'),
            'edit' => Pages\EditOrderItem::route('/{record}/edit'),
        ];
    }
}