<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [0, 1, 2, 3, 4];
        $dateRanges = [
            Carbon::now()->subDays(3), // 3 days ago
            Carbon::now()->subDays(7), // 1 week ago
            Carbon::now()->subDays(10), // 10 days ago
            Carbon::now()->subDays(15), // 15 days ago
            Carbon::now()->subMonth(), // 1 month ago
            Carbon::now()->subMonths(3), // 3 months ago
        ];

        foreach ($dateRanges as $date) {
            DB::table('orders')->insert([
                'id' => Str::uuid(),
                'customer_id' => Customer::where('email', 'user@gmail.com')->first()->id,
                'orderDate' => $date,
                'totalAmount' => rand(100, 1000) * 1000,
                'status' => $statuses[array_rand($statuses)],
                'address' => fake()->address(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
