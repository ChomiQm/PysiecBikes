<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Definiowanie ról
        $roles = [
            'Admin',
            'CEO',
            'User',
            'ITDev',
            'HR',
            'Manager',
            'Sales',
            'Support'
        ];

        // Permisje przypisane do poszczególnych ról
        $permissions = [
            'Admin' => [
                'create-products', 'edit-products', 'delete-products', 'view-products',
                'create-orders', 'edit-orders', 'delete-orders', 'view-orders',
                'create-users', 'edit-users', 'delete-users', 'view-users',
                'view-reports', 'manage-settings', 'admin-panel-access'
            ],
            'CEO' => [
                'view-reports', 'manage-settings', 'admin-panel-access'
            ],
            'ITDev' => [
                'create-products', 'edit-products', 'view-products', 'view-reports'
            ],
            'HR' => [
                'create-users', 'edit-users', 'view-users'
            ],
            'Manager' => [
                'create-orders', 'edit-orders', 'view-orders', 'view-reports'
            ],
            'Sales' => [
                'create-orders', 'edit-orders', 'view-orders'
            ],
            'Support' => [
                'view-products', 'view-orders'
            ],
            'User' => []
        ];

        // Tworzenie ról z UUID
        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role],
                [
                    'uuid' => (string) Str::uuid(),
                    'guard_name' => 'web'
                ]
            );
        }

        // Tworzenie uprawnień z UUID
        foreach ($permissions as $role => $perms) {
            foreach ($perms as $permission) {
                Permission::firstOrCreate(
                    ['name' => $permission],
                    [
                        'uuid' => (string) Str::uuid(),
                        'guard_name' => 'web'
                    ]
                );
            }
        }

        // Tworzenie użytkowników i przypisywanie ról oraz danych użytkownika
        $users = [
            ['email' => 'chomiczek333@o2.pl', 'roles' => ['Admin'], 'name' => 'Pysiec', 'address' => 'Wrocław', 'first_name' => 'Mateusz', 'last_name' => 'Urbanek'],
            ['email' => 'pysiec@o2.pl', 'roles' => ['CEO'], 'name' => 'PysicBoss', 'address' => 'Kraków', 'first_name' => 'Adam', 'last_name' => 'Kowalski'],
            ['email' => 'chomiczek667@o2.pl', 'roles' => ['User'], 'name' => 'Chomiczko', 'address' => 'Poznań', 'first_name' => 'Robert', 'last_name' => 'Nowak'],
            ['email' => 'misiec@o2.pl', 'roles' => ['ITDev'], 'name' => 'MisieckDev', 'address' => 'Gdańsk', 'first_name' => 'Anna', 'last_name' => 'Lis'],
            ['email' => 'pysicdup@o2.pl', 'roles' => ['HR'], 'name' => 'HRPys', 'address' => 'Warszawa', 'first_name' => 'Katarzyna', 'last_name' => 'Mazur'],
            ['email' => 'chomiczek2137@o2.pl', 'roles' => ['ITDev'], 'name' => 'TechPysiec', 'address' => 'Lublin', 'first_name' => 'Jakub', 'last_name' => 'Wiśniewski'],
            ['email' => 'manager@o2.pl', 'roles' => ['Manager'], 'name' => 'ManagerPysicdup', 'address' => 'Warszawa', 'first_name' => 'Bob', 'last_name' => 'Smith'],
            ['email' => 'sales@o2.pl', 'roles' => ['Sales'], 'name' => 'SalesPysiec', 'address' => 'Gdynia', 'first_name' => 'Joe', 'last_name' => 'Black'],
            ['email' => 'support@o2.pl', 'roles' => ['Support'], 'name' => 'SupportPysiec', 'address' => 'Łódź', 'first_name' => 'Jane', 'last_name' => 'Doe'],
        ];

        foreach ($users as $user_data) {
            $user = User::firstOrCreate(
                ['email' => $user_data['email']],
                [
                    'id' => (string) Str::uuid(),
                    'name' => $user_data['name'],
                    'password' => Hash::make('Pysiec123!'),
                ]
            );

            $user->syncRoles($user_data['roles']); // Przypisz wiele ról

            // Dodawanie dodatkowych danych użytkownika
            DB::table('user_data')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'id' => (string) Str::uuid(),
                    'first_name' => $user_data['first_name'],
                    'last_name' => $user_data['last_name'],
                    'country' => 'Poland',
                    'state' => 'PL',
                    'city' => $user_data['address'],
                    'street_address' => 'Main St 1',
                    'postal_code' => '00-000',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Przypisanie uprawnień do ról
        foreach ($permissions as $role => $perms) {
            $roleModel = Role::where('name', $role)->first();
            $permissionUUIDs = Permission::whereIn('name', $perms)->pluck('uuid')->toArray();

            foreach ($permissionUUIDs as $permission_uuid) {
                DB::table(config('permission.table_names.role_has_permissions'))->updateOrInsert(
                    ['role_id' => $roleModel->uuid, 'permission_id' => $permission_uuid]
                );
            }
        }
    }
}
