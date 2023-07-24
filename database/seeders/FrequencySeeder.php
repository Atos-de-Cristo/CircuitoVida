<?php

namespace Database\Seeders;

use App\Models\Frequency;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class FrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessons = Lesson::all();

        $lessons->each(function ($lesson) {
            $lesson->event->inscriptions->each(function ($inscription) use ($lesson) {
                $test = rand(0,1);
                if ($test == 1) {
                    Frequency::factory()->create([
                        'lesson_id' => $lesson->id,
                        'event_id' => $lesson->event_id,
                        'user_id' => $inscription->user_id,
                        'inscription_id' => $inscription->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
        });
    }
}
