<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    // Tentukan kolom yang bisa diisi secara mass-assignment
    protected $fillable = ['name', 'plural_name', 'icon'];

    /**
     * Relasi ke tabel Menu (One to Many)
     */
    public function menus()
    {
        return $this->hasMany(Menu::class, 'categories_id');
    }
}
