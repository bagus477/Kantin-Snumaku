<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'type',
        'name',
        'extra_price',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
