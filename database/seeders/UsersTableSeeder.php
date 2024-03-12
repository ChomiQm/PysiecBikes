<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Tworzenie przykładowego użytkownika
        $user = User::create([
            'name' => 'Random User',
            'email' => 'random@example.com',
            'password' => Hash::make('password'),
        ]);

        // Tworzenie roli
        $role = Role::create(['name' => 'Example Role', 'guard_name' => 'web']);

        // Tworzenie uprawnienia
        $permission = Permission::create(['name' => 'do-something', 'guard_name' => 'web']);

        // Nadawanie roli użytkownikowi
        $user->assignRole($role);

        // Nadawanie uprawnienia użytkownikowi
        $user->givePermissionTo($permission);
    }
}
