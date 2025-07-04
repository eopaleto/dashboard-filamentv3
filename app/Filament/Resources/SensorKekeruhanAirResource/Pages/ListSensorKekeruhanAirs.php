<?php

namespace App\Filament\Resources\SensorKekeruhanAirResource\Pages;

use App\Filament\Resources\SensorKekeruhanAirResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSensorKekeruhanAirs extends ListRecords
{
    protected static string $resource = SensorKekeruhanAirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
