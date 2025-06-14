<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Customer 1',
                'email' => 'user@gmail.com',
                'phoneNum' => '08123456789',
                'address' => 'Jl. Raya No. 1',
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Customer 2',
                'email' => 'user2@gmail.com',
                'phoneNum' => '08123456789',
                'address' => 'Jl. Raya No. 2',
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Customer 3',
                'email' => 'user3@gmail.com',
                'phoneNum' => '08123456789',
                'address' => 'Jl. Raya No. 3',
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Customer 4',
                'email' => 'user4@gmail.com',
                'phoneNum' => '08123456789',
                'address' => 'Jl. Raya No. 4',
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Customer 5',
                'email' => 'user5@gmail.com',
                'phoneNum' => '08123456789',
                'address' => 'Jl. Raya No. 5',
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Customer 6',
                'email' => 'user6@gmail.com',
                'phoneNum' => '08123466789',
                'address' => 'Jl. Raya No. 6',
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Customer 7',
                'email' => 'user7@gmail.com',
                'phoneNum' => '08123476789',
                'address' => 'Jl. Raya No. 7',
                'password' => Hash::make('123'),
            ],
        ];

        foreach ($customers as $customer) {
            \App\Models\Customer::create($customer);
        }
    }
}
