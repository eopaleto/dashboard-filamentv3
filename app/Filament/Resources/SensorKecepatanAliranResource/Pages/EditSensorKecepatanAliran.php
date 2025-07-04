<?php

namespace App\Filament\Resources\SensorKecepatanAliranResource\Pages;

use App\Filament\Resources\SensorKecepatanAliranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSensorKecepatanAliran extends EditRecord
{
    protected static string $resource = SensorKecepatanAliranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
