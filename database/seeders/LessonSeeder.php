<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = Module::all();

        $modules->each(function ($module) {
            $event = $module->event;
            for ($i = 1; $i <= 3; $i++) {
                Lesson::factory()->create([
                    'event_id' => $event->id,
                    'module_id' => $module->id,
                    'title' => 'Aula '.$i,
                    'description' => 'Aula de teste cadastrada via script',
                    'video' => 'MdO35UCxGxs',
                    'start_date' => '2023-07-01 08:00:00',
                    'end_date' => '2023-07-01 08:00:00',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
