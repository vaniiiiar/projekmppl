<?php

namespace App\Filament\Customer\Resources\ProductResource\Pages;

use App\Filament\Customer\Resources\ProductResource;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Product Information')
                    ->schema([
                        Components\ImageEntry::make('image')
                            ->height(300)
                            ->columnSpanFull(),
                            
                        Components\TextEntry::make('name')
                            ->size('lg')
                            ->weight('bold'),
                            
                        Components\TextEntry::make('category.name')
                            ->badge(),
                            
                        Components\TextEntry::make('price')
                            ->money('IDR')
                            ->color('success')
                            ->size('lg'),
                            
                        Components\IconEntry::make('is_available')
                            ->label('Availability')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-badge')
                            ->falseIcon('heroicon-o-x-mark')
                            ->trueColor('success')
                            ->falseColor('danger'),
                            
                        Components\TextEntry::make('description')
                            ->columnSpanFull()
                            ->markdown(),
                    ])
                    ->columns(2),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            // Hapus EditAction jika customer tidak boleh edit
            // Actions\EditAction::make(),
        ];
    }
}