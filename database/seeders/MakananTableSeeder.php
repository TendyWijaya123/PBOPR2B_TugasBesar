<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MakananTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Bersihkan data existing
        DB::table('makanan')->truncate();

        // Buat data dummy sebanyak 1000 baris
        $faker = Faker::create();
        for ($i = 0; $i < 1000; $i++) {
            DB::table('makanan')->insert([
                'namaMakanan' => $faker->word,
                'hargaMakanan' => $faker->numberBetween(5000, 50000),
                // Tambahkan kolom lain sesuai kebutuhan
            ]);
        }
    }
}
