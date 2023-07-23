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
            'id' => '1',
            'name' => 'Iniciante',
        ]);
        DB::table('categories')->insert([
            'id' => '2',
            'name' => 'Avançado',
        ]);
        DB::table('categories')->insert([
            'id' => '3',
            'name' => 'Vocacionado',
        ]);
    }
}
