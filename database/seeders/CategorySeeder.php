<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->create([
            'id' => '1',
            'name' => 'Iniciante',
        ]);
        Category::factory()->create([
            'id' => '2',
            'name' => 'Avançado',
        ]);
        Category::factory()->create([
            'id' => '3',
            'name' => 'Vocacionado',
        ]);
    }
}
