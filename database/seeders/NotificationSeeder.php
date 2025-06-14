<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'customer_id' => Customer::where('email', 'user@gmail.com')->first()->id,
                'title' => 'Congrats you have been chosen to get 50% discount',
            ],
            [
                'customer_id' => Customer::where('email', 'user@gmail.com')->first()->id,
                'title' => 'Congrats you have been chosen to get 20% discount',
            ],
            [
                'customer_id' => Customer::where('email', 'user@gmail.com')->first()->id,
                'title' => 'Congrats you have been chosen to get 10% discount',
            ]
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }
    }
}
