<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Terlaris
        Menu::create([
            'name' => 'Nasi Goreng',
            'description' => 'Nasi goreng dengan topping ayam suwir dan telur.',
            'price' => 5000,
            'category' => 'nasi',
            'image' => 'nasi-goreng.jpg',
            'is_featured' => true,
        ]);

        Menu::create([
            'name' => 'Nasi Chicken Katsu',
            'description' => 'Chicken katsu renyah dengan saus spesial kantin.',
            'price' => 8000,
            'category' => 'nasi',
            'image' => 'nasi-chicken-katsu.jpg',
            'is_featured' => true,
        ]);

        Menu::create([
            'name' => 'Nasi Ayam Geprek',
            'description' => 'Ayam geprek pedas gurih dengan lalapan.',
            'price' => 7000,
            'category' => 'nasi',
            'image' => 'nasi-ayam-geprek.jpg',
            'is_featured' => true,
        ]);

        Menu::create([
            'name' => 'Mie Ayam Bakso',
            'description' => 'Mie ayam dengan bakso dan sayuran segar.',
            'price' => 7000,
            'category' => 'mie',
            'image' => 'mie-ayam-bakso.jpg',
            'is_featured' => true,
        ]);

        // Tambahan contoh kategori lain
        Menu::create([
            'name' => 'Nasi Rames',
            'description' => 'Nasi dengan lauk lengkap dan sambal.',
            'price' => 5000,
            'category' => 'nasi',
            'image' => 'nasi-rames.jpg',
        ]);

        Menu::create([
            'name' => 'Mie Kuah',
            'description' => 'Mie rebus hangat pilihan rasa.',
            'price' => 5000,
            'category' => 'mie',
            'image' => 'mie-kuah.jpg',
        ]);

        Menu::create([
            'name' => 'Tahu Krispi',
            'description' => 'Cemilan tahu goreng renyah.',
            'price' => 3000,
            'category' => 'cemilan',
            'image' => 'tahu-krispi.jpg',
        ]);
    }
}
