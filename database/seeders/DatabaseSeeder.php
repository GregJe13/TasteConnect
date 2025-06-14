<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\LoyaltyProgram;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CustomerSeeder::class,
            ReservationSeeder::class,
            MenuSeeder::class,
            LoyaltyProgramSeeder::class,
            PromotionSeeder::class,
            InventorySeeder::class,
            OrderSeeder::class,
            // NotificationSeeder::class,
        ]);
    }
}
