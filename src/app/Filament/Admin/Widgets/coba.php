<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class coba extends ChartWidget
{
    protected static ?string $heading = 'Statistik Penjualan';

    protected function getData(): array
    {
        // Data dummy untuk testing
        $data = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
            'datasets' => [
                [
                    'label' => 'Penjualan',
                    'data' => [1200, 1900, 3000, 2500, 2100],
                    'backgroundColor' => '#f59e0b',
                ]
            ]
        ];

        return $data;
    }

    protected function getType(): string
    {
        return 'bar';
    }
}