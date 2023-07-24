<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessons = Lesson::all();

        $lessons->each(function ($lesson) {
            Activity::factory()->create([
                'lesson_id' => $lesson->id,
                'title' => 'Atividade de fixação',
                'description' => 'Atividade cadastrada via script',
                'type' => 'G',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
