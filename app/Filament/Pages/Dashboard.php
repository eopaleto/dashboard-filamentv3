<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\StatusAlat;
use Filament\Widgets\AccountWidget;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\KekeruhanAirChart;
use App\Filament\Widgets\StatusAliranChart;
use App\Filament\Widgets\KecepatanAliranChart;
use App\Filament\Widgets\StatusKekeruhanChart;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $navigationGroup = 'Menu';

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return [
            'default' => 1,
            'sm' => 2,
            'md' => 3,
            'xl' => 3,
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AccountWidget::class,
            StatsOverview::class,
            KecepatanAliranChart::class,
            StatusAliranChart::class,
            KekeruhanAirChart::class,
            StatusKekeruhanChart::class
        ];
    }
}
