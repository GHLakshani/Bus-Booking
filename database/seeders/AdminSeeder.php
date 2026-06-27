<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@busgoes.com'],
            [
                'first_name' => 'Admin',
                'last_name'  => 'BusGoes',
                'password'   => Hash::make('admin@123'),
                'telephone'  => '0112345678',
                'province'   => 'Western',
                'district'   => 'Colombo',
                'address'    => 'BusGoes HQ, Colombo',
                'postal_code'=> '10000',
                'user_type'  => 'admin',
            ]
        );
    }
}
