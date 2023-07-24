<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Response;
use Illuminate\Database\Seeder;

class ResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = Activity::all();

        $activities->each(function ($activity) {
            $activity->questions->each(function ($question) use ($activity) {
                $response = 'Resposta teste gerada por script';
                if ($question->type == 'multi') {
                    $opc = rand(1, 3);
                    $response = 'Opc0'.$opc;
                }
                $statusOpc = rand(1,3);
                switch ($statusOpc) {
                    case '1':
                        $status = 'pendente';
                    break;
                    case '2':
                        $status = 'correto';
                    break;
                    case '3':
                        $status = 'errado';
                    break;

                    default:
                        $status = 'pendente';
                    break;
                }
                foreach ($activity->lesson->event->inscriptions as $inscription) {
                    Response::factory()->create([
                        'user_id' => $inscription->user_id,
                        'question_id' => $question->id,
                        'response' => $response,
                        'status' => $status,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
        });
    }
}
