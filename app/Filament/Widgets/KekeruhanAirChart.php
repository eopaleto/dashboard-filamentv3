<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use App\Models\SensorKekeruhanAir;

class KekeruhanAirChart extends ChartWidget
{
    public function getColumnSpan(): int | string | array
    {
        return 8;
    }

    protected static ?string $heading = 'Grafik Kekeruhan Air';
    protected static ?string $subheading = 'Grafik Kekeruhan Air';
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '3s';
    protected static ?string $maxHeight = '300px';

    protected static ?array $options = [
        'responsive' => true,
        'animation' => [
            'duration' => 1000,
            'easing' => 'easeInOutQuad',
            'loop' => false,
        ],
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
            'tooltip' => [
                'enabled' => true,
                'mode' => 'index',
                'intersect' => false,
            ],
        ],
        'interaction' => [
            'intersect' => false,
            'mode' => 'index',
        ],
        'scales' => [
            'x' => [
                'grid' => [
                    'display' => false,
                ],
                'ticks' => [
                    'display' => false,
                    'maxTicksLimit' => 10,
                ],
            ],
            'y' => [
                'grid' => [
                    'drawBorder' => false,
                    'color' => 'rgba(200,200,200,0.1)',
                    'borderDash' => [4, 4],
                ],
            ],
        ],
    ];

    protected function getFilters(): ?array
    {
        return [
            '15-menit' => '15 Menit',
            '30-menit' => '30 Menit',
            '60-menit' => '1 Jam',
            'semua' => 'Semua',
        ];
    }

    protected function getData(): array
    {
        $jumlahData = match ($this->filter) {
            '15-menit' => 15,
            '30-menit' => 30,
            '60-menit' => 60,
            'semua' => null,
            default => 15,
        };

        $data = SensorKekeruhanAir::where('nama_sensor', 'Turbidity Sensor')
            ->orderByDesc('waktu')
            ->take($jumlahData)
            ->get()
            ->sortBy('waktu')
            ->values();

        return [
            'datasets' => [
                [
                    'label' => 'Sensor Kekeruhan Air',
                    'data' => $data->pluck('kekeruhan_air'),
                    'borderColor' => 'rgb(54, 162, 235)',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $data->pluck('waktu')->map(fn($w) => Carbon::parse($w)->format('d F Y H:i:s')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
