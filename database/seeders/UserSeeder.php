<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get role IDs from the roles table
        $customerRoleId = Role::where('role_name', 'Customer')->first()->id;
        $merchantRoleId = Role::where('role_name', 'Merchant')->first()->id;

        DB::table('users')->insert([
            [
                'name' => 'Customer User',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('customer123'),
                'role_id' => $customerRoleId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Merchant User',
                'email' => 'merchant@gmail.com',
                'password' => Hash::make('merchant123'),
                'role_id' => $merchantRoleId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
