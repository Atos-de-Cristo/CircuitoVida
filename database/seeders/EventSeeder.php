<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::factory()->create([
            'id' => 1,
            'type' => 'C',
            'category_id' => '1',
            'name' => 'IMERSÃO TOTAL',
            'image' => 'https://storage.googleapis.com/media_files_prod/uploads/event/432167/event-a18e5eb552ed3eb8b8e4290c0c6e47fc.jpg',
            'start_date' => '2023-06-01 08:00:00',
            'end_date' => '2023-12-01 08:00:00',
            'local' => 'Igreja Sede',
            'description' => 'Cadastro de curso teste via script',
            'tickets_limit' => '100',
            'value' => '0',
            'status' => 'E'
        ]);
        Event::factory()->create([
            'id' => 2,
            'type' => 'C',
            'category_id' => '1',
            'name' => 'Fundamentos da Fé',
            'start_date' => '2023-06-01 08:00:00',
            'end_date' => '2023-12-01 08:00:00',
            'local' => 'Igreja Sede',
            'description' => 'Cadastro de curso teste via script',
            'tickets_limit' => '100',
            'value' => '0',
            'status' => 'E'
        ]);
        Event::factory()->create([
            'id' => 3,
            'type' => 'C',
            'category_id' => '2',
            'name' => 'Panorama do Antigo Testamento',
            'start_date' => '2023-06-01 08:00:00',
            'end_date' => '2023-12-01 08:00:00',
            'local' => 'Igreja Sede',
            'description' => 'Cadastro de curso teste via script',
            'tickets_limit' => '100',
            'value' => '0',
            'status' => 'E'
        ]);
        Event::factory()->create([
            'id' => 4,
            'type' => 'C',
            'category_id' => '3',
            'name' => 'Panorama do Novo Testamento',
            'start_date' => '2023-06-01 08:00:00',
            'end_date' => '2023-12-01 08:00:00',
            'local' => 'Igreja Sede',
            'description' => 'Cadastro de curso teste via script',
            'tickets_limit' => '100',
            'value' => '0',
            'status' => 'E'
        ]);
    }
}
