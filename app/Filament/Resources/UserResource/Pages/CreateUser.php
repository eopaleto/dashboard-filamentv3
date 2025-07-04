<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\UserResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {

        if ($this->data['role']) {
            $this->record->assignRole($this->data['role']);
        }

        $admins = User::role('admin')->get();

        Notification::make()
            ->title('User Baru Ditambahkan')
            ->body("User {$this->record->name} berhasil dibuat.")
            ->success()
            ->sendToDatabase($admins);
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'User Berhasil Dibuat';
    }
}
