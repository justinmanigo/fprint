<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::create([
            'id' => 1,
            'name' => 'admin',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]); 
        $user = User::create([
            'firstName' => 'test',
            'lastName' => 'admin',
            'email' => 'admin@adamson.edu.ph',
            'email_verified_at'=> now(),
            'occupation' => 'Employee',
            'password' => bcrypt('admin123'),
            'idNumber' => 1234562,
            'isBlocked' => 'No',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user->assignRole($role->id);

        // $user = User::where('idNumber', 1234562)->get();
        // $user->assignRole($role->id);

        $role = Role::create([
            'id' => 2,
            'name' => 'user',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user = User::create([
            'firstName' => 'test',
            'lastName' => 'user',
            'email' => 'user@adamson.edu.ph',
            'email_verified_at'=> now(),
            'password' => bcrypt('user123'),
            'idNumber' => 12345621,
            'occupation' => 'Student',
            'isBlocked' => 'No',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user->assignRole($role->id);

    }
}
