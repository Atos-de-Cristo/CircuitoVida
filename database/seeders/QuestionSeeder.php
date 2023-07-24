<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = Activity::all();

        $modules->each(function ($module) {
            Question::factory()->create([
                'activity_id' => $module->id,
                'type' => 'aberta',
                'title' => 'Q01 - Questão Teste',
                'options' => '[]',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            for ($i = 2; $i <= 3; $i++) {
                Question::factory()->create([
                    'activity_id' => $module->id,
                    'type' => 'multi',
                    'title' => 'Q0'.$i.' - Questão Teste',
                    'options' => '[{"text":"Opc01","correct":true},{"text":"Opc02","correct":false},{"text":"Opc03","correct":false}]',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
