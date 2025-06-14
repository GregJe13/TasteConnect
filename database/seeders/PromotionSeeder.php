<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promotions = [
            [
                'title' => 'Christmas is coming, get 20% off for all items',
                'discountAmount' => 50000,
                'startDate' => '2024-11-22 00:00:00',
                'endDate' => '2024-11-29 23:59:59'
            ],
            [
                'title' => 'New Year Special: Buy 1 Get 1 Free on Selected Items',
                'discountAmount' => 80000,
                'startDate' => '2024-12-30 00:00:00',
                'endDate' => '2025-01-05 23:59:59'
            ],
            [
                'title' => 'Valentine’s Day: Extra 30% Off for Couples',
                'discountAmount' => 30000,
                'startDate' => '2025-02-10 00:00:00',
                'endDate' => '2025-02-15 23:59:59'
            ],
            [
                'title' => 'Summer Clearance Sale: Up to 50% Off on Selected Items',
                'discountAmount' => 100000,
                'startDate' => '2025-06-01 00:00:00',
                'endDate' => '2025-06-30 23:59:59'
            ]
        ];


        foreach ($promotions as $promotion) {
            \App\Models\Promotion::create($promotion);
        }
    }
}
