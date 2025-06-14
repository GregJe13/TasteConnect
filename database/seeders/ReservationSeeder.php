<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reservations = [
            [
                'customer_id' => Customer::where('email', 'user@gmail.com')->first()->id,
                'date' => '2024-11-25 14:00:00',
                'status' => 1,
            ],
            [
                'customer_id' => Customer::where('email', 'user@gmail.com')->first()->id,
                'date' => '2024-12-01 10:00:00',
                'status' => 0,
            ],
            [
                'customer_id' => Customer::where('email', 'user@gmail.com')->first()->id,
                'date' => '2024-11-28 18:30:00',
                'status' => 1,
            ],
            [
                'customer_id' => Customer::where('email', 'user3@gmail.com')->first()->id,
                'date' => '2024-12-03 15:45:00',
                'status' => 0,
            ],
            [
                'customer_id' => Customer::where('email', 'user2@gmail.com')->first()->id,
                'date' => '2024-12-07 12:00:00',
                'status' => 2,
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservation::create($reservation);
        }
    }
}
