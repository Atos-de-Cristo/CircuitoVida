<?php

namespace App\Http\Livewire;

use App\Services\{ActivityService, QuestionService, ResponseService, UserService};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use PHPUnit\Event\Emitter;

class EventActivityQuestion extends Component
{
    public $atvId, $title, $questionId, $eventId;
    public $type = 'aberta';
    public $options = [];
    public $answers = [];
    public $userCorrectAnswer;
    public $viewCorrectAnswers = false;
    public $search = '';

    protected $listeners = [
        'refreshActivityQuestion' => '$refresh',
        'closeCorrectAnswers' => 'closeCorrectAnswers'
    ];

    public function getServiceProperty()
    {
        return new QuestionService;
    }

    public function getServiceResponseProperty()
    {
        return new ResponseService;
    }

    public function getServiceUserProperty()
    {
        return new UserService;
    }

    public function getActivityServiceProperty()
    {
        return new ActivityService;
    }

    public function getQuestionsProperty()
    {
        return $this->service->getQuestionsCorrect($this->atvId);
    }

    public function getUserQuestionsProperty()
    {
        $questionIds = $this->questions['data']->pluck('id')->toArray();

        if (!empty($this->search)) {
            return $this->serviceUser->getUsersQuestionsResume($questionIds)->filter(function ($userQuestion) {
                return stripos($userQuestion->name, $this->search) !== false;
            });
        }
        return $this->serviceUser->getUsersQuestionsResume($questionIds);
    }


    public function mount(Request $request)
    {
        $this->atvId = $request->id;
        $this->questions;
    }

    public function render()
    {
        return view('livewire.event.activity.question');
    }

    public function correctAnswers(string $idUser)
    {
        $this->userCorrectAnswer = $idUser;
        $this->viewCorrectAnswers = true;
    }

    public function closeCorrectAnswers()
    {
        $this->viewCorrectAnswers = false;
        $this->emit('refreshActivityQuestion');
    }

    public function addOption()
    {
        $this->options[] = ['text' => '', 'correct' => false];
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function store()
    {
        try {
            $this->validate([
                'type' => 'required',
                'title' => 'required',
                'options.*.text' => 'required_if:type,multi',
                'options.*.correct' => "required_if:type,multi",
            ]);

            $request = [
                'activity_id' => $this->atvId,
                'type' => $this->type,
                'title' => $this->title,
                'options' => $this->options
            ];

            if ($this->questionId) {
                $request['id'] = $this->questionId;
            }

            if ($request['type'] === 'multi') {
                $error = true;
                foreach ($request['options'] as $options) {
                    if ($options['correct'] === true) {
                        $error = false;
                    }
                }

                if ($error) {
                    return session()->flash('message', [
                        'text' => 'É necessário selecionar pelo menos uma opção correta!',
                        'type' => 'error',
                    ]);
                }
            }

            if ($request['type'] === 'multiple') {
                $count = 0;
                foreach ($request['options'] as $options) {
                    if ($options['correct'] === true) {
                        $count++;
                    }
                }

                if ($count <= 1) {
                    return session()->flash('message', [
                        'text' => 'É necessário selecionar pelo menos duas opções corretas!',
                        'type' => 'error',
                    ]);
                }
            }

            $this->service->store($request);

            $this->resetInputCreate();

            session()->flash('message', [
                'text' => 'A pergunta foi salva com sucesso!' ,
                'type' => 'success',
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();

            $this->resetErrorBag();

            foreach ($errors->messages() as $field => $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $this->addError($field, $error);
                }
            }
        }
    }

    public function resetInputCreate()
    {
        $this->type = 'aberta';
        $this->options = [];
        $this->title = '';
        $this->questionId = '';
    }

    public function storeQuestion()
    {
        try {
            $activity = $this->activityService->find($this->atvId);
            if (count($this->answers) != $activity->questions->count()) {
                return session()->flash('message', [
                    'text' => 'Precisa responder todas as questões!',
                    'type' => 'error',
                ]);
            }
            foreach ($this->answers as $questionId => $answer) {
                $dataQuestion = $this->questions['data']->find($questionId);
                $status = 'pendente';
                if ($dataQuestion->type == 'multi') {
                    $options = json_decode($dataQuestion->options);
                    $opt = array_values(array_filter($options, function($value) use ($answer) {
                        return $value->text == $answer;
                    }));
                    $itemStatus = array_shift($opt)->correct;
                    $status = $itemStatus ? 'correto' : 'errado';
                }
                if ($dataQuestion->type == 'multiple') {
                    $options = json_decode($dataQuestion->options);
                    $resultCheck = $this->verificationMultipleQuestions($answer, $options);
                    $status = $resultCheck ? 'correto' : 'errado';
                    $answer = implode(', ', array_keys($answer));;
                }
                $this->serviceResponse->store([
                    'user_id' => Auth::user()->id,
                    'question_id' => $questionId,
                    'response' => $answer,
                    'status' => $status
                ]);
            }
            $this->resetInputAnswers();
            $this->emit('refreshActivityQuestion');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            $this->resetErrorBag();

            foreach ($errors->messages() as $field => $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $this->addError($field, $error);
                }
            }
        }
    }

    public function resetInputAnswers()
    {
        $this->answers = [];
    }

    public function edit($id)
    {
        $data = $this->service->find($id);

        $this->type = $data->type;
        $this->options = json_decode($data->options);
        $this->title = $data->title;
        $this->questionId = $data->id;
    }

    public function dell($id)
    {
        $this->service->delete($id);
    }

    public function getCorrectOption($options)
    {
        $data = json_decode($options);
        $correctOption = collect($data)->where('correct', true)->pluck('text')->implode(', ');
        return $correctOption ?? '';
    }

    function verificationMultipleQuestions($optForm, $optBase) {
        $optFormCheck = array_filter($optForm, function($value) {
            return $value === "check";
        });

        foreach ($optFormCheck as $key => $value) {
            $item = collect($optBase)->firstWhere('text', $key);
            if (!$item || !$item->correct) {
                return false;
            }
        }

        foreach ($optBase as $item) {
            if ($item->correct && (!isset($optForm[$item->text]) || $optForm[$item->text] != "check")) {
                return false;
            }
        }

        return true;
    }
}
