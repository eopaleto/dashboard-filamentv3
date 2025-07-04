<?php

namespace App\Filament\Resources\SensorKekeruhanAirResource\Pages;

use App\Filament\Resources\SensorKekeruhanAirResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSensorKekeruhanAir extends EditRecord
{
    protected static string $resource = SensorKekeruhanAirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
