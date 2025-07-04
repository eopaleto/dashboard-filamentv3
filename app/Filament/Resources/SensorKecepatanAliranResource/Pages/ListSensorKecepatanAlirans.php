<?php

namespace App\Filament\Resources\SensorKecepatanAliranResource\Pages;

use App\Filament\Resources\SensorKecepatanAliranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSensorKecepatanAlirans extends ListRecords
{
    protected static string $resource = SensorKecepatanAliranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
