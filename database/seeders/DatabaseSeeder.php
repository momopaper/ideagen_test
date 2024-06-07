<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //create roles
        if (!Role::where('name', 'user')->exists()) {
            Role::create(['name' => 'user']);
        }

        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }

        //create default admin
        if (!User::where('email', 'admin@admin.com')->exists()) {
            $user = User::factory()->create([
                'name' => 'default admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'ic' => 'IC admin',
                'epf_no' => 'EPF admin',
                'socso_no' => 'SOCSO admin',
                'employee_no' => 'EMPLOYEE admin'
            ]);

            //assign role
            $user->assignRole('admin');
        }
    }
}
