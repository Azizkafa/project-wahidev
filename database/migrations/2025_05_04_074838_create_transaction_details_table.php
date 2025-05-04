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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id(); // Kolom 'id' sebagai primary key
            $table->foreignId('menus_id')->constrained('menus')->onDelete('cascade'); // Kolom 'menus_id' yang mereferensikan tabel menus
            $table->text('note')->nullable(); // Kolom 'note' untuk catatan tambahan, nullable
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade'); // Kolom 'transaction_id' untuk relasi ke tabel transactions
            $table->timestamps(); // Kolom 'created_at' dan 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
