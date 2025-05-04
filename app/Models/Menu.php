<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menus';
    protected $fillable = ['name', 'stock', 'price', 'category_id', 'image_url', 'description'];
    protected $casts = [
        'price' => 'integer',
    ];
    /**
     * Relasi ke tabel Category (Many to One)
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
    /**
     * Relasi ke tabel TransactionDetail (One to Many)
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'menus_id');
    }
    /**
     * Relasi ke tabel Transaction (Many to Many)
     */
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_details', 'menus_id', 'transaction_id');
    }
    /**
     * Relasi ke tabel Transaction (Many to Many)
     */
    public function transactionsWithDetails()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_details', 'menus_id', 'transaction_id')
            ->withPivot('note')
            ->withTimestamps();
    }
    /**
     * Relasi ke tabel Transaction (Many to Many)
     */
    public function transactionsWithDetailsAndCategory()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_details', 'menus_id', 'transaction_id')
            ->withPivot('note')
            ->withTimestamps()
            ->join('categories', 'categories.id', '=', 'menus.categories_id')
            ->select('transactions.*', 'categories.name as category_name');
    }
    /**
     * Relasi ke tabel Transaction (Many to Many)
     */
    public function transactionsWithDetailsAndCategoryAndTransaction()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_details', 'menus_id', 'transaction_id')
            ->withPivot('note')
            ->withTimestamps()
            ->join('categories', 'categories.id', '=', 'menus.categories_id')
            ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->select('transactions.*', 'categories.name as category_name');
    }
}
