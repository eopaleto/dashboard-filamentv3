<?php

namespace App\Filament\Resources\SensorKekeruhanAirResource\Pages;

use App\Filament\Resources\SensorKekeruhanAirResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSensorKekeruhanAir extends CreateRecord
{
    protected static string $resource = SensorKekeruhanAirResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Berhasil Ditambahkan';
    }
}
