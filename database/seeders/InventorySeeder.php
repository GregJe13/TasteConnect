<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inventories =
            [
                [
                    'name' => 'Coca Cola',
                    'stock' => 100
                ],
                [
                    'name' => 'Lettuce',
                    'stock' => 100
                ],
                [
                    'name' => 'Tomato',
                    'stock' => 100
                ],
                [
                    'name' => 'Cheese',
                    'stock' => 100
                ],

            ];
        foreach ($inventories as $inventory) {
            Inventory::create($inventory);
        }
    }
}
