<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Menambahkan kolom 'id' sebagai primary key dengan auto-increment
            $table->string('order_number')->unique(); // Kolom 'order_number' untuk nomor pesanan yang unik
            $table->string('order_type'); // Kolom 'order_type' untuk jenis pesanan (misalnya dine-in, takeout, delivery)
            $table->text('note')->nullable(); // Kolom 'note' untuk catatan tambahan, nullable
            $table->integer('table_number')->nullable(); // Kolom 'table_number' untuk nomor meja (nullable jika tidak diperlukan)
            $table->string('customer_name')->nullable();; // Kolom 'customer_name' untuk nama pelanggan
            $table->integer('tax'); // Kolom 'tax' untuk pajak, tipe decimal
            $table->integer('total'); // Kolom 'total' untuk total harga pesanan, tipe decimal
            $table->integer('status'); // Kolom 'tax' untuk pajak, tipe decimal
            $table->timestamps(); // Kolom 'created_at' dan 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
