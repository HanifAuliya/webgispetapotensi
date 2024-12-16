<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Pariwisata',
                'icon' => 'icons/pariwisata-icon.png', // Path icon untuk kategori
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Perkebunan',
                'icon' => 'icons/perkebunan-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kehutanan',
                'icon' => 'icons/kehutanan-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Peternakan',
                'icon' => 'icons/peternakan-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Perikanan',
                'icon' => 'icons/perikanan-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Perdagangan',
                'icon' => 'icons/perdagangan-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
