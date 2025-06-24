<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $modelLabel = 'Product Catalog';
    protected static ?string $navigationLabel = 'Our Products';
    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        // No form needed for read-only view
        return $form
            ->schema([
                // Empty schema since customers can't edit
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('')
                    ->size(80),
                    
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Product $record) => $record->description ? Str::limit($record->description, 50) : '')
                    ->weight('medium'),
                    
                Tables\Columns\TextColumn::make('category.name')
                    ->badge()
                    ->color('gray'),
                    
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),
                    
                Tables\Columns\IconColumn::make('is_available')
                    ->label('Stock')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('danger'),
                    //->trueLabel('Available')
                    //->falseLabel('Out of Stock'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Filter by Category'),
                    
                Tables\Filters\Filter::make('available_only')
                    ->label('Available Products Only')
                    ->query(fn (Builder $query) => $query->where('is_available', true)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Details')
                    ->icon('heroicon-o-eye'),
            ])
            ->bulkActions([
                // No bulk actions for customers
            ])
            ->emptyStateHeading('No products available')
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [
            // No relations needed for read-only view
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'view' => Pages\ViewProduct::route('/{record}'),
            // Removed create and edit pages
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }
}