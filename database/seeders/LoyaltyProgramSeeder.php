<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoyaltyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Saving with TasteConnect',
                'point' => 30,
                'reward' => '10% discount on all items',
                'startDate' => '2024-12-10',
                'endDate' => '2024-12-31',
            ],
            [
                'name' => 'Special Birthday of TasteConnect',
                'point' => 50,
                'reward' => 'Free shipping on your next order',
                'startDate' => '2025-01-01',
                'endDate' => '2025-01-15',
            ],
            [
                'name' => 'TasteConnect Appreciation',
                'point' => 20,
                'reward' => 'Buy 1 Get 1 Free on select items',
                'startDate' => '2025-02-10',
                'endDate' => '2025-02-15',
            ],
        ];

        foreach ($programs as $program) {
            \App\Models\LoyaltyProgram::create($program);
        }
    }
}
