<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File; // Tambahkan ini

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Definisikan path sumber (master) dan tujuan (publik)
        $sourcePath = storage_path('app/seed-assets');
        $destinationPath = public_path('assets');

        // 2. Pastikan folder tujuan (public/assets) ada
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }

        $menus = [
            [
                'name' => 'Spaghetti Carbonara',
                'price' => 83000,
                'stock' => 10,
                'image' => 'Carbonara.png',
            ],
            [
                'name' => 'Spaghetti Aglio Olio',
                'price' => 83000,
                'stock' => 10,
                'image' => 'Aglio Olio.png',
            ],
            [
                'name' => 'Lemon Buttered Dory',
                'price' => 90000,
                'stock' => 10,
                'image' => 'Dory.png',
            ],
            [
                'name' => 'Beef Lasagna',
                'price' => 40000,
                'stock' => 10,
                'image' => 'Lasagna.png',
            ],
            [
                'name' => 'Lemon Buttered Salmon',
                'price' => 150000,
                'stock' => 10,
                'image' => 'Salmon.png',
            ],
            [
                'name' => 'Mac and Cheese',
                'price' => 45000,
                'stock' => 10,
                'image' => 'Mac and Cheese.png',
            ],
        ];

        foreach ($menus as $menuData) {
            $sourceFile = $sourcePath . '/' . $menuData['image'];
            $destinationFile = $destinationPath . '/' . $menuData['image'];

            // 3. Salin gambar dari folder master ke folder publik jika belum ada
            if (File::exists($sourceFile) && !File::exists($destinationFile)) {
                File::copy($sourceFile, $destinationFile);
            }

            // 4. Masukkan data ke database (gunakan updateOrCreate agar aman dijalankan berkali-kali)
            Menu::updateOrCreate(
                ['name' => $menuData['name']], // Kunci untuk mencari data yang ada
                $menuData                      // Data untuk diisi/diperbarui
            );
        }
    }
}
