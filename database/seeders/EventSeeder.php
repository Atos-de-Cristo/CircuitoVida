<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            'type' => 'C',
            'name' => 'IMERSÃO TOTAL - TESTE',
            'image' => 'https://storage.googleapis.com/media_files_prod/uploads/event/432167/event-a18e5eb552ed3eb8b8e4290c0c6e47fc.jpg',
            'start_date' => '2023-06-01 08:00:00',
            'end_date' => '2023-06-02 08:00:00',
            'local' => 'Igreja Sede',
            'description' => 'Turma de Imersão total.<br />Início das aulas 10 de maio às 20h.',
            'tickets_limit' => '10',
            'value' => '0',
            'status' => 'A',
        ]);
    }
}
