<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

    class ProductResource extends Resource
    {
        protected static ?string $model = Product::class;

        protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
        protected static ?string $modelLabel = 'Product';
        protected static ?string $navigationGroup = 'Inventory';
        protected static ?int $navigationSort = 1;

        public static function form(Form $form): Form
        {
            return $form
                ->schema([
                    Forms\Components\Section::make('Product Information')
                        ->schema([
                            Forms\Components\Select::make('category_id')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),
                                    Forms\Components\TextInput::make('slug')
                                        ->required()
                                        ->maxLength(255),
                                ]),
                                
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),
                                
                            Forms\Components\Textarea::make('description')
                                ->columnSpanFull(),
                        ])->columns(2),
                        
                    Forms\Components\Section::make('Pricing & Availability')
                        ->schema([
                            Forms\Components\TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->prefix('Rp')
                                ->minValue(0),
                                
                            Forms\Components\Toggle::make('is_available')
                                ->required()
                                ->default(true)
                                ->onColor('success')
                                ->offColor('danger'),
                        ])->columns(2),
                        
                    Forms\Components\Section::make('Product Image')
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->directory('products')
                                ->image()
                                ->resize(50)
                                ->maxSize(2048)
                                ->imageEditor()
                                ->imageEditorAspectRatios([
                                    '16:9',
                                    '4:3',
                                    '1:1',
                                ])
                                ->columnSpanFull(),
                        ]),
                ]);
        }

        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    Tables\Columns\ImageColumn::make('image')
                        ->size(60)
                        ->toggleable(),
                        
                    Tables\Columns\TextColumn::make('name')
                        ->searchable()
                        ->sortable()
                        ->description(fn (Product $record): string => $record->description ? Str::limit($record->description, 50) : ''),
                        
                    Tables\Columns\TextColumn::make('category.name')
                        ->badge()
                        ->color('info')
                        ->sortable(),
                        
                    Tables\Columns\TextColumn::make('price')
                        ->money('IDR')
                        ->sortable()
                        ->color('success')
                        ->weight('bold'),
                        
                    Tables\Columns\IconColumn::make('is_available')
                        ->boolean()
                        ->trueIcon('heroicon-o-check-badge')
                        ->falseIcon('heroicon-o-x-mark')
                        ->trueColor('success')
                        ->falseColor('danger'),
                        
                    Tables\Columns\TextColumn::make('created_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                ])
                ->filters([
                    Tables\Filters\SelectFilter::make('category')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload(),
                        
                    Tables\Filters\Filter::make('is_available')
                        ->label('Available Products')
                        ->query(fn (Builder $query): Builder => $query->where('is_available', true)),
                        
                    Tables\Filters\Filter::make('created_at')
                        ->form([
                            Forms\Components\DatePicker::make('created_from'),
                            Forms\Components\DatePicker::make('created_until'),
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when($data['created_from'],
                                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date))
                                ->when($data['created_until'],
                                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date));
                        }),
                ])
                ->actions([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('toggle_availability')
                        ->label(fn (Product $record): string => $record->is_available ? 'Make Unavailable' : 'Make Available')
                        ->icon(fn (Product $record): string => $record->is_available ? 'heroicon-o-x-mark' : 'heroicon-o-check')
                        ->color(fn (Product $record): string => $record->is_available ? 'danger' : 'success')
                        ->action(fn (Product $record) => $record->update(['is_available' => !$record->is_available])),
                ])
                ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                        Tables\Actions\BulkAction::make('make_available')
                            ->icon('heroicon-o-check')
                            ->action(fn (Collection $records) => $records->each->update(['is_available' => true])),
                        Tables\Actions\BulkAction::make('make_unavailable')
                            ->icon('heroicon-o-x-mark')
                            ->action(fn (Collection $records) => $records->each->update(['is_available' => false])),
                    ]),
                ])
                ->emptyStateActions([
                    Tables\Actions\CreateAction::make(),
                ]);
        }

        public static function getRelations(): array
        {
            return [
                // Add relation managers if needed
            ];
        }

        public static function getPages(): array
        {
            return [
                'index' => Pages\ListProducts::route('/'),
                'create' => Pages\CreateProduct::route('/create'),
                'edit' => Pages\EditProduct::route('/{record}/edit'),
            ];
        }
    }