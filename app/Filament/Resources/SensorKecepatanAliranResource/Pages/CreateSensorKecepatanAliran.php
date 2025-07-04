<?php

namespace App\Filament\Resources\SensorKecepatanAliranResource\Pages;

use App\Filament\Resources\SensorKecepatanAliranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSensorKecepatanAliran extends CreateRecord
{
    protected static string $resource = SensorKecepatanAliranResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Berhasil Ditambahkan';
    }
}
