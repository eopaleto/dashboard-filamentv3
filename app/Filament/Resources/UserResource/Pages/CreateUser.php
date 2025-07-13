<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {

        if ($this->data['role']) {
            $this->record->assignRole($this->data['role']);
        }
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'User Berhasil Dibuat';
    }
}
