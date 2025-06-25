<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class SaleChart extends ApexChartWidget
{
    protected static ?string $heading = 'Laporan Penjualan';

    protected function getData(): array
{
    return [
        'series' => [
            [
                'name' => 'Penjualan Harian',
                'data' => [50000, 60000, 75000],
            ],
        ],
        'chart' => [
            'type' => 'line',
            'height' => 400,
        ],
        'xaxis' => [
            'categories' => ['24 Jun', '25 Jun', '26 Jun'],
        ],
    ];
}
}