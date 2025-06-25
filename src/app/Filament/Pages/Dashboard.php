<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\SaleChart;
use App\Filament\Widgets\StatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.dashboard';

   protected function getHeaderWidgets(): array
{
    return [
        SaleChart::class,
    ];
}

    protected function getColumns(): int | array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'lg' => 3,
            'xl' => 4,
        ];
    }

    protected function getHeaderWidgetsColumns(): int | array
    {
        return [
            'sm' => 1,
            'md' => 1,
            'lg' => 1,
            'xl' => 1,
        ];
    }
}