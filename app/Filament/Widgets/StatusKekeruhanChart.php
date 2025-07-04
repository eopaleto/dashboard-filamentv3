<?php

namespace App\Filament\Widgets;

use App\Models\SensorKekeruhanAir;
use Filament\Widgets\Widget;
use Filament\Widgets\ChartWidget;

class StatusKekeruhanChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Kekeruhan Air';
    protected static ?string $maxHeight = '300px';

    public function getColumnSpan(): int|string|array
    {
        return 4;
    }
    protected function getData(): array
    {
        $keruh = SensorKekeruhanAir::where('status', 'Keruh')->count();
        $sedang = SensorKekeruhanAir::where('status', 'Sedang')->count();
        $jernih  = SensorKekeruhanAir::where('status', 'Jernih')->count();

        return [
            'datasets' => [
                [
                    'data' => [$keruh, $sedang, $jernih],
                    'backgroundColor' => [
                        '#f87171',
                        '#facc15',
                        '#34d399',
                    ],
                ],
            ],
            'labels' => ['Keruh', 'Sedang', 'Jernih'],
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
