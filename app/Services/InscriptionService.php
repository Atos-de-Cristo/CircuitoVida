<?php

namespace App\Services;

use App\Enums\InscriptionStatus;
use App\Models\Inscription;
use Carbon\Carbon;
use Error;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection as SupportCollection;

class InscriptionService extends BaseService
{
    protected $repository;

    protected $rules = [
        'event_id' => 'required|numeric',
        'user_id' => 'required|numeric',
        'quantity' => 'required|numeric',
        'amount' => 'required',
        'status' => 'required',
        'cancellation_reason' => 'string|min:3'
    ];

    public function __construct()
    {
        $this->repository = new Inscription();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->where($filter)->with('event', 'user')->get();
    }

    public function getInscriptionActive(): array
    {
        $req = $this->repository
            ->with('event.modules.lessons')
            ->where([
                'user_id' => Auth::user()->id,
                'status' => InscriptionStatus::L->name
            ])
            ->first();

        if (!$req) {
            return [];
        }

        $lessonActivity = [];
        if ($req->event !== null && $req->event->modules !== null && $req->event->end_date > Carbon::now()) {
            foreach ($req->event->modules as $mod) {
                $lessonActivity[$mod->id]['event_id'] = $req->event->id;
                $lessonActivity[$mod->id]['event'] = $req->event->name;
                $lessonActivity[$mod->id]['module'] = $mod->name;

                foreach ($mod->lessons as $lesson) {
                    if ($lesson->start_date && $lesson->end_date) {
                        if (
                            Carbon::parse($lesson->start_date) <= Carbon::parse(date('Y-m-d H:i:s'))
                            && Carbon::parse($lesson->end_date) > Carbon::parse(date('Y-m-d H:i:s'))
                        ) {
                            $lessonActivity[$mod->id]['lessons'][$lesson->id] = $lesson->toArray();
                        }
                    }else{
                        $lessonActivity[$mod->id]['lessons'][$lesson->id] = $lesson->toArray();
                    }
                }
            }
        }

        return array_filter($lessonActivity, function ($lesson) {
            if (isset($lesson['lessons']) && !empty($lesson['lessons'])) {
                return $lesson;
            }
        });
    }

    public function getAllStudent($search, $eventId): SupportCollection
    {
        // Usar cache para reduzir consultas ao banco
        $cacheKey = "students_event_{$eventId}_search_" . md5($search);
        
        // Cache válido por 5 minutos - menor tempo para evitar dados desatualizados
        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 120, function () use ($search, $eventId) {
            try {
                // Carregar apenas o essencial inicialmente
                $results = $this->repository->where('event_id', $eventId)
                    ->whereIn('status', ['L', 'A', 'R'])
                    ->with([
                        'user' => function ($query) use ($search) {
                            if (!empty($search)) {
                                $query->where('name', 'LIKE', '%' . $search . '%');
                            }
                        }
                    ])
                    ->get();
        
                $results = $results
                    ->filter(function ($value) {
                        return $value->user != null;
                    });
                    
                // Se não houver alunos, retorne coleção vazia
                if ($results->isEmpty()) {
                    return SupportCollection::make();
                }
                
                // Pré-carregar lessons e frequencies apenas se necessário (e uma vez só)
                $eventWithLessons = \App\Models\Event::with(['lessons.frequency', 'lessons.module'])
                    ->find($eventId);
                    
                if (!$eventWithLessons) {
                    return $results;
                }
                
                if (!$eventWithLessons->lessons || $eventWithLessons->lessons->isEmpty()) {
                    return $results;
                }
                
                $totalLessons = $eventWithLessons->lessons->count();
                
                // Carregar activities e questions apenas se houver lições
                if ($totalLessons > 0) {
                    try {
                        // Carregar atividades de uma vez só com eager loading
                        $activities = \App\Models\Activity::whereHas('lesson', function ($query) use ($eventId) {
                            $query->whereHas('event', function ($q) use ($eventId) {
                                $q->where('id', $eventId);
                            });
                        })->with(['questions.Response'])->get();
                        
                        // Processar no máximo 100 alunos por vez para evitar timeouts
                        $results = $results->take(100)->map(function ($item) use ($eventWithLessons, $totalLessons, $activities) {
                            // Verificar se o usuário existe antes de processar
                            if (!$item->user) {
                                return $item;
                            }
                            
                            // Processar cada aluno
                            $totalFrequency = 0;
                            $lessonsPresent = 0; // Contador de lições em que o aluno esteve presente
                            $statusActivity = [];
                            
                            // Contador para aulas que já ocorreram
                            $pastLessonsCount = 0;
                            
                            foreach ($eventWithLessons->lessons as $lesson) {
                                // Verificar se a aula já ocorreu (data de início é anterior à data atual)
                                $lessonStartDate = \Carbon\Carbon::parse($lesson->start_date);
                                $now = \Carbon\Carbon::now();
                                
                                // Só contar aulas que já começaram
                                if ($lessonStartDate->lte($now)) {
                                    $pastLessonsCount++;
                                    
                                    // Verificar se frequency existe
                                    if (!$lesson->frequency) {
                                        continue;
                                    }
                                    
                                    // Verificar se existe registro de frequência para este aluno nesta aula
                                    $frequencyRecord = $lesson->frequency->where('user_id', $item->user->id)->first();
                                    
                                    // Se existe um registro de frequência e o aluno está presente
                                    if ($frequencyRecord && $frequencyRecord->is_present == 1) {
                                        // Incrementar totalFrequency
                                        $totalFrequency++;
                                        // Incrementar o contador de lições em que o aluno esteve presente
                                        $lessonsPresent++;
                                    }
                                    // Se não existe registro ou o aluno não está presente, não incrementa lessonsPresent
                                    // Isso fará com que a diferença pastLessonsCount - lessonsPresent conte corretamente as faltas
                                }
                                
                                // Apenas processe as atividades se o aluno estiver com frequência baixa
                                if (($totalLessons - $totalFrequency) > 2) {
                                    // Filtrar atividades apenas para esta aula
                                    $lessonActivities = $activities->filter(function ($activity) use ($lesson) {
                                        return $activity->lesson_id == $lesson->id;
                                    });
                                    
                                    foreach ($lessonActivities as $activity) {
                                        // Verificar se a atividade tem as propriedades necessárias
                                        if (!isset($activity->type) || !isset($activity->questions)) {
                                            continue;
                                        }
                                        
                                        // Processar apenas atividades relevantes ao aluno
                                        if ($activity->type == 'G' || 
                                            ($activity->type == 'E' && isset($activity->users) && $activity->users->contains('id', $item->user->id))) {
                                            // Lógica de processamento simplificada
                                            $totalQuestions = $activity->questions->count();
                                            if ($totalQuestions > 0) {
                                                $totalPendent = $totalQuestions;
                                                $totalCorrect = 0;
                                                $totalIncorrect = 0;
                                                
                                                foreach ($activity->questions as $question) {
                                                    if (!isset($question->Response)) {
                                                        continue;
                                                    }
                                                    
                                                    $response = $question->Response->where('user_id', $item->user->id)->first();
                                                    if ($response) {
                                                        $totalPendent--;
                                                        if ($response->is_correct) {
                                                            $totalCorrect++;
                                                        } else {
                                                            $totalIncorrect++;
                                                        }
                                                    }
                                                }
                                                
                                                // Adicionar aos resultados apenas se houver problemas ou atividades pendentes
                                                if ($totalPendent > 0) {
                                                    $statusActivity[] = [
                                                        'module' => $lesson->module ? $lesson->module->name : 'Sem módulo',
                                                        'lesson' => $lesson->title,
                                                        'activity' => $activity->title,
                                                        'pendent' => $totalPendent,
                                                        'totalQuestions' => $totalQuestions,
                                                        'status' => 'Pendente',
                                                    ];
                                                    // Apenas mostrar um status por aluno
                                                    break;
                                                } elseif ($totalCorrect > 0 && $totalQuestions > 0) {
                                                    $percent = ($totalCorrect/$totalQuestions)*100;
                                                    if ($percent <= 70) {
                                                        $statusActivity[] = [
                                                            'module' => $lesson->module ? $lesson->module->name : 'Sem módulo',
                                                            'lesson' => $lesson->title,
                                                            'activity' => $activity->title,
                                                            'percent' => number_format($percent, 2, '.', ''),
                                                            'status' => 'Reprovado',
                                                        ];
                                                        // Apenas mostrar um status por aluno
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    // Se já encontrou problemas, não continua verificando
                                    if (count($statusActivity) > 0) {
                                        break;
                                    }
                                }
                            }
                            
                            // Calcular faltas apenas com base nas aulas que já ocorreram
                            $item->user->absenceCount = $pastLessonsCount - $lessonsPresent;
                            $item->user->activityStatus = $statusActivity;
                            return $item;
                        });
                    } catch (\Exception $e) {
                        // Silenciar erros mas continuar processamento
                    }
                }
        
                // Garantir que toda inscrição tenha activityStatus como array
                $results = $results->map(function ($item) {
                    if ($item->user && (!isset($item->user->activityStatus) || !is_array($item->user->activityStatus))) {
                        $item->user->activityStatus = [];
                    }
                    return $item;
                });
                
                $sortedResults = $results->sortBy(function ($inscription) {
                    return $inscription->user ? $inscription->user->name : '';
                });
                
                // Garantir que todos os elementos da coleção sejam objetos, não arrays
                return SupportCollection::make($sortedResults->values()->all())->map(function ($item) {
                    if (is_array($item)) {
                        return (object) $item;
                    }
                    return $item;
                });
            } catch (\Exception $e) {
                // Em caso de erro, retorna uma coleção vazia para não quebrar a UI
                return SupportCollection::make();
            }
        });
    }

    public function sumInscriptions()
    {
        $desiredStatuses = ['P', 'A', 'R', 'C'];

        return $this->repository
        ->select('status', DB::raw('COUNT(*) AS total'))
        ->whereIn('status', $desiredStatuses)
        ->groupBy('status')
        ->get()->toArray();
    }

    public function getFrequency(string $eventId, string $lessonId = null): Collection
    {
        $inscriptions = $this->repository
            ->with('event', 'frequencies')
            ->where('event_id', $eventId)
            ->where('status', InscriptionStatus::L->name)
            ->get();
        
        // Remover duplicatas baseado no user_id para evitar registros duplicados
        $inscriptions = $inscriptions->unique('user_id');
        
        // Carregar o usuário para cada inscrição
        $inscriptions->load('user');
        
        // Ordenar por nome do usuário
        $inscriptions = $inscriptions->sortBy('user.name');
        
        // Se foi passado um lessonId, filtrar as frequências por essa aula específica
        if ($lessonId !== null) {
            return $inscriptions->map(function ($inscription) use ($lessonId) {
                $inscription->frequencies = $inscription->frequencies->filter(function ($frequency) use ($lessonId) {
                    return $frequency->lesson_id == (int) $lessonId;
                });
                return $inscription;
            });
        }
        
        return $inscriptions;
    }

    public function find(string $id): Inscription
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Inscription
    {
        // TODO: desativado ate cad de perfil estar 100%
        // if (Auth::user()->profile === null) {
        //     throw new Error('Preencha seu perfil!');
        // }

        if (!$data['event_id'] || empty($data['event_id'])) {
            throw new Error('Informe o curso!');
        }

        $getInsc = $this->repository
            ->where('user_id', $data['user_id'])
            ->where('event_id', $data['event_id'])
            ->count();
        if ($getInsc > 0) {
            throw new Error('Usuário já inscrito!');
        }

        $getInscTotal = $this->repository
            ->where('event_id', $data['event_id'])
            ->count();
        $eventService = new EventService;
        $limitInsc = $eventService->find($data['event_id'])->tickets_limit;
        if ($getInscTotal >= $limitInsc) {
            throw new Error('Vagas esgotadas!');
        }

        $dataValidate = $this->validateForm($data);

        return $this->repository->create($dataValidate);
    }

    public function update(array $data, int $id): bool
    {
        $repo = $this->find($id);
        return $repo->update($data);
    }

    public function delete(string $id): void
    {
        //TODO: travando delete até confirmacao de acao
        throw new Error('Serviço indisponível!');
        $repo = $this->find($id);
        $repo->delete();
    }
}
