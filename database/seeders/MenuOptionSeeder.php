<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuOption;
use Illuminate\Database\Seeder;

class MenuOptionSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh opsi untuk Mie Goreng
        $mieGoreng = Menu::where('name', 'Mie Kuah')->orWhere('name', 'Mie Goreng')->first();

        if ($mieGoreng) {
            $flavors = ['Original', 'Rendang', 'Aceh', 'Ayam Geprek'];

            foreach ($flavors as $flavor) {
                MenuOption::firstOrCreate([
                    'menu_id' => $mieGoreng->id,
                    'type' => 'rasa',
                    'name' => $flavor,
                ]);
            }

            // Contoh satu tambahan dengan biaya ekstra
            MenuOption::updateOrCreate(
                [
                    'menu_id' => $mieGoreng->id,
                    'type' => 'tambahan',
                    'name' => 'Telur',
                ],
                [
                    'extra_price' => 1000,
                ]
            );
        }
    }
}
