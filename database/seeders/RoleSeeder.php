<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole($adminRole);
    }
}
