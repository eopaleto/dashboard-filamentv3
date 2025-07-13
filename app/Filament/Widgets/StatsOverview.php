<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\StatusAlat;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{

    public function getColumnSpan(): int|string|array
    {
        return 12;
    }

    protected function getStats(): array
    {
        $user = Auth::user();

        $alat = StatusAlat::first();
        $statusText = $alat && $alat->status == 1 ? 'Online' : 'Offline';
        $statusColor = $alat && $alat->status == 1 ? 'success' : 'danger';
        $statusIcon  = $alat && $alat->status == 1 ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle';

        if ($user?->hasRole('admin')) {
            return [
                Stat::make('Jumlah Pengguna', User::role('pengguna')->count())
                    ->description('User dengan role pengguna')
                    ->icon('heroicon-o-users')
                    ->color('success'),

                Stat::make('Jumlah Admin', User::role('admin')->count())
                    ->description('User dengan role admin')
                    ->icon('heroicon-o-user-group')
                    ->color('primary'),

                Stat::make('Status Alat', $statusText)
                    ->description($alat?->nama_alat ?? 'Alat tidak ditemukan')
                    ->color($statusColor)
                    ->icon($statusIcon),
            ];
        }

        return [
            Stat::make('Status Alat', $statusText)
                ->description($alat?->nama_alat ?? 'Alat tidak ditemukan')
                ->color($statusColor)
                ->icon($statusIcon),
        ];
    }
}
