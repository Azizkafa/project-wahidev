<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        foreach(range(1,10) as $i){
            DB::table('products')-> insert([
                'nama' => $faker -> words(2, true),
                'harga' => $faker -> numberBetween(50000,100000),
                'deskripsi' => $faker -> sentence(10),
                'gambar' => 'product.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
