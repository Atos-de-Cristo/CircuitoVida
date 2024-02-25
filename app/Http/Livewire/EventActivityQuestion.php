<?php

namespace App\Http\Livewire;

use App\Services\{QuestionService, ResponseService, UserService};
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
        $this->validate([
            'answers.*' => 'required',
        ]);
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
                $resultado = $this->verificarCorrespondencia($answer, $options);
                dd($answer, $options, $resultado);
                $status = $itemStatus ? 'correto' : 'errado';
            }
            // $this->serviceResponse->store([
            //     'user_id' => Auth::user()->id,
            //     'question_id' => $questionId,
            //     'response' => $answer,
            //     'status' => $status
            // ]);
        }

        session()->flash('message', [
            'text' => 'As respostas foram salvas com sucesso!' ,
            'type' => 'success',
        ]);
        $this->resetInputAnswers();
        $this->emit('refreshActivityQuestion');
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
        $correctOption = collect($data)->firstWhere('correct', true);
        return $correctOption ? $correctOption->text : '';
    }

    function verificarCorrespondencia($array01, $array02) {
        // Verificar se todas as chaves marcadas como "check" correspondem aos textos em array02 com correct igual a true
        foreach ($array01 as $key => $value) {
            if ($value && !collect($array02)->contains('text', $key)) {
                return false;
            }
        }

        // Verificar se todos os itens em array02 com correct igual a true estão presentes em array01
        foreach ($array02 as $item) {
            if ($item->correct && !isset($array01[$item->text])) {
                return false;
            }
        }

        return true;
    }
}
