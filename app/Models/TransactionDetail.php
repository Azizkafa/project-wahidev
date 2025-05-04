<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan default plural
    protected $table = 'transaction_details';

    // Tentukan kolom yang bisa diisi secara mass-assignment
    protected $fillable = ['menus_id', 'note', 'transaction_id'];

    /**
     * Relasi ke tabel Menu (Many to One)
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menus_id');
    }

    /**
     * Relasi ke tabel Transaction (Many to One)
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
