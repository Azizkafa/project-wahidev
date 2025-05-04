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
        Schema::create('menus', function (Blueprint $table) {
            $table->id(); // Menambahkan kolom 'id' sebagai primary key dengan auto-increment
            $table->string('name'); // Kolom 'name' untuk nama menu
            $table->text('description')->nullable(); // Kolom 'description' untuk deskripsi menu, nullable jika tidak wajib diisi
            $table->string('image_url')->nullable(); // Kolom 'image_url' untuk menyimpan URL gambar menu, nullable jika tidak wajib diisi
            $table->integer('price');
            $table->integer('stock')->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Kolom 'menus_id' yang mereferensikan tabel menus
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
