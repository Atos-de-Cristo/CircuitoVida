<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        for ($eventId=1; $eventId <= 4; $eventId++) {
            for ($idModule=1; $idModule <= 3; $idModule++) {
                Module::factory()->create([
                    'event_id' => $eventId,
                    'name' => 'Modulo 0'.$idModule,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
