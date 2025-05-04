<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['order_number', 'order_type','status', 'note', 'customer_name', 'table_number', 'tax', 'total'];

    /**
     * Relasi ke tabel TransactionDetail (One to Many)
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }
}
