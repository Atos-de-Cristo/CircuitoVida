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
            'id' => 1,
            'type' => 'C',
            'name' => 'IMERSÃO TOTAL - TESTE',
            'image' => 'https://storage.googleapis.com/media_files_prod/uploads/event/432167/event-a18e5eb552ed3eb8b8e4290c0c6e47fc.jpg',
            'start_date' => '2023-06-01 08:00:00',
            'end_date' => '2023-06-02 08:00:00',
            'local' => 'Igreja Sede',
            'description' => 'Turma de Imersão total.<br />Início das aulas 10 de maio às 20h.',
            'tickets_limit' => '10',
            'value' => '0',
            'status' => 'P'
        ]);

        DB::table('event_user')->insert([
            'event_id' => '1',
            'user_id' => '3'
        ]);
        DB::table('event_user')->insert([
            'event_id' => '1',
            'user_id' => '4'
        ]);

        DB::table('inscriptions')->insert([
            'event_id' => '1',
            'user_id' => '6',
            'quantity' => '1',
            'amount' => '0.00',
            'status' => 'P'
        ]);
        DB::table('inscriptions')->insert([
            'event_id' => '1',
            'user_id' => '7',
            'quantity' => '1',
            'amount' => '0.00',
            'status' => 'P'
        ]);
        DB::table('inscriptions')->insert([
            'event_id' => '1',
            'user_id' => '8',
            'quantity' => '1',
            'amount' => '0.00',
            'status' => 'L'
        ]);
        DB::table('inscriptions')->insert([
            'event_id' => '1',
            'user_id' => '9',
            'quantity' => '1',
            'amount' => '0.00',
            'status' => 'L'
        ]);
        DB::table('inscriptions')->insert([
            'event_id' => '1',
            'user_id' => '10',
            'quantity' => '1',
            'amount' => '0.00',
            'status' => 'L'
        ]);
        DB::table('inscriptions')->insert([
            'event_id' => '1',
            'user_id' => '11',
            'quantity' => '1',
            'amount' => '0.00',
            'status' => 'C'
        ]);

        DB::table('modules')->insert([
            'id' => '1',
            'event_id' => '1',
            'name' => 'Modulo 01',
        ]);
        DB::table('modules')->insert([
            'id' => '2',
            'event_id' => '1',
            'name' => 'Modulo 02',
        ]);
        DB::table('modules')->insert([
            'id' => '3',
            'event_id' => '1',
            'name' => 'Modulo 03',
        ]);

        DB::table('lessons')->insert([
            'id' => '1',
            'event_id' => '1',
            'module_id' => '1',
            'title' => 'Aula 01',
            'description' => 'desc da aula teste',
            'video' => 'MdO35UCxGxs',
            'start_date' => '2023-06-01 08:00:00',
            'end_date' => '2023-07-01 08:00:00',
        ]);
        DB::table('lessons')->insert([
            'id' => '2',
            'event_id' => '1',
            'module_id' => '1',
            'title' => 'Aula 02',
            'description' => 'desc da aula teste',
            'video' => 'MdO35UCxGxs',
            'start_date' => '2023-06-01 08:00:00',
            'end_date' => '2023-07-01 08:00:00',
        ]);
        DB::table('lessons')->insert([
            'id' => '3',
            'event_id' => '1',
            'module_id' => '2',
            'title' => 'Aula 03',
            'description' => 'desc da aula teste',
            'video' => 'MdO35UCxGxs',
            'start_date' => '2023-06-01 08:00:00',
            'end_date' => '2023-07-01 08:00:00',
        ]);
        DB::table('lessons')->insert([
            'id' => '4',
            'event_id' => '1',
            'module_id' => '3',
            'title' => 'Aula 04',
            'description' => 'desc da aula teste',
            'video' => 'MdO35UCxGxs',
            'start_date' => '2023-06-01 08:00:00',
            'end_date' => '2023-07-01 08:00:00',
        ]);

        DB::table('activities')->insert([
            'id' => 1,
            'lesson_id' => '1',
            'title' => 'Atividade de fixação',
            'description' => 'preenchimento obrigatório'
        ]);

        DB::table('questions')->insert([
            'id' => 1,
            'activity_id' => '1',
            'type' => 'aberta',
            'title' => 'Q01 - pergunta teste aberta',
            'options' => '[]'
        ]);
        DB::table('questions')->insert([
            'id' => 2,
            'activity_id' => '1',
            'type' => 'multi',
            'title' => 'Q02 - pergunta teste multipla escolhax',
            'options' => '[{"text":"Opc01","correct":true},{"text":"Opc02","correct":false},{"text":"Opc03","correct":false}]'
        ]);
        DB::table('questions')->insert([
            'id' => 3,
            'activity_id' => '1',
            'type' => 'aberta',
            'title' => 'Q01 - pergunta teste aberta',
            'options' => '[]'
        ]);
    }
}
