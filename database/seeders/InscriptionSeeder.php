<?php

namespace Database\Seeders;

use App\Models\Inscription;
use Illuminate\Database\Seeder;

class InscriptionSeeder extends Seeder
{
    public function run(): void
    {
        Inscription::factory(200)->create();
    }
}
