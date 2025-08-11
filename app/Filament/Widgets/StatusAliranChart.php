<?php

namespace App\Filament\Widgets;

use App\Models\SensorKecepatanAliran;
use Filament\Widgets\Widget;
use Filament\Widgets\ChartWidget;

class StatusAliranChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Kecepatan Aliran';
    protected static ?string $maxHeight = '300px';
    protected static ?string $pollingInterval = '3s';

    public function getColumnSpan(): int|string|array
    {
        return 4;
    }
    protected function getData(): array
    {
        $lambat = SensorKecepatanAliran::where('status', 'Lambat')->count();
        $sedang = SensorKecepatanAliran::where('status', 'Sedang')->count();
        $cepat  = SensorKecepatanAliran::where('status', 'Cepat')->count();

        return [
            'datasets' => [
                [
                    'data' => [$lambat, $sedang, $cepat],
                    'backgroundColor' => [
                        '#f87171',
                        '#facc15',
                        '#34d399',
                    ],
                ],
            ],
            'labels' => ['Lambat', 'Sedang', 'Cepat'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
                'datalabels' => [
                    'color' => '#000',
                    'anchor' => 'center',
                    'align' => 'center',
                    'font' => [
                        'weight' => 'bold',
                        'size' => 16,
                    ],
                ],
            ],
            'scales' => [
                'x' => [
                    'display' => false,
                ],
                'y' => [
                    'display' => false,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
