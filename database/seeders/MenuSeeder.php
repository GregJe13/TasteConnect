<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Spaghetti Carbonara',
                // 'description' => 'A classic Italian pasta dish made with creamy sauce, crispy bacon, fresh eggs, and a generous topping of Parmesan cheese.',
                'price' => 83000,
                'stock' => 10,
                'image' => 'Carbonara.png',
            ],
            [
                'name' => 'Spaghetti Aglio Olio',
                // 'description' => 'A light and flavorful spaghetti dish tossed with garlic, extra virgin olive oil, chili flakes, and a hint of parsley for a refreshing finish.',
                'price' => 83000,
                'stock' => 10,
                'image' => 'Aglio Olio.png',
            ],
            [
                'name' => 'Lemon Buttered Dory',
                // 'description' => 'A tender dory fish fillet cooked to perfection and topped with a rich, tangy lemon butter sauce that enhances its delicate flavor.',
                'price' => 90000,
                'stock' => 10,
                'image' => 'Dory.png',
            ],
            [
                'name' => 'Beef Lasagna',
                // 'description' => 'A hearty layered pasta dish filled with seasoned ground beef, creamy béchamel, tomato sauce, and melted cheese baked until golden.',
                'price' => 40000,
                'stock' => 10,
                'image' => 'Lasagna.png',
            ],
            [
                'name' => 'Lemon Buttered Salmon',
                // 'description' => 'A premium salmon fillet grilled to perfection and served with a luscious lemon butter sauce that brings out its rich flavor.',
                'price' => 150000,
                'stock' => 10,
                'image' => 'Salmon.png',
            ],
            [
                'name' => 'Mac and Cheese',
                // 'description' => 'A comforting bowl of macaroni smothered in a rich, creamy cheese sauce and baked with a golden breadcrumb topping for added crunch.',
                'price' => 45000,
                'stock' => 10,
                'image' => 'Mac and Cheese.png',
            ],
        ];

        foreach ($menus as $menu) {
            \App\Models\Menu::create($menu);
        }
    }
}
