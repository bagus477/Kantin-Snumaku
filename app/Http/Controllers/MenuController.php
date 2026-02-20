<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function pembeliDashboard()
    {
        $menus = Menu::all();

        // Ambil menu rekomendasi (prioritas is_featured, fallback ke 3 menu pertama)
        $recommendations = $menus->where('is_featured', true)->take(3);
        if ($recommendations->isEmpty()) {
            $recommendations = $menus->take(3);
        }

        return view('dashboards.pembeli', [
            'recommendations' => $recommendations,
        ]);
    }

    public function pembeliMenu()
    {
        $menus = Menu::with('options')->get();

        // Terlaris: hanya menu yang ditandai is_featured,
        // hilangkan duplikat berdasarkan nama, dan batasi jumlah yang ditampilkan.
        $terlaris = $menus
            ->where('is_featured', true)
            ->unique('name')
            ->take(6)
            ->values();
        $anekaNasi = $menus->where('category', 'nasi');
        $anekaMie = $menus->where('category', 'mie');
        $anekaCemilan = $menus->where('category', 'cemilan');

        return view('dashboards.pembeli-menu', [
            'terlaris' => $terlaris,
            'anekaNasi' => $anekaNasi,
            'anekaMie' => $anekaMie,
            'anekaCemilan' => $anekaCemilan,
            'allMenus' => $menus->values(),
        ]);
    }
}
