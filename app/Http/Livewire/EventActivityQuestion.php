<?php

namespace App\Http\Livewire;

use App\Services\QuestionService;
use App\Services\ResponseService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EventActivityQuestion extends Component
{
    public $atvId, $title, $questionId;
    public $type = 'aberta';
    public $options = [];
    public $answers = [];
    private $service, $serviceResponse, $serviceUser;
    public $userCorrectAnswer;
    public $viewCorrectAnswers = false;
    public $search ='';

    protected $listeners = [
        'refreshActivityQuestion' => '$refresh',
        'closeCorrectAnswers' => 'closeCorrectAnswers'
    ];

    public function __construct()
    {
        $this->service = new QuestionService;
        $this->serviceResponse = new ResponseService;
        $this->serviceUser = new UserService;
    }

    public function getQuestionsProperty()
    {
        return $this->service->getQuestionsCorrect($this->atvId);
    }

    //public function getUserQuestionsProperty()
   // {
   //     return $this->serviceUser->getUsersQuestionsResume($this->questions['data']->pluck('id')->toArray());
   // }
    public function getUserQuestionsProperty()
{
    // Obtenha os IDs das perguntas
    $questionIds = $this->questions['data']->pluck('id')->toArray();

    // Verifique se há um valor de busca
    if (!empty($this->search)) {
        // Filtre os dados com base no valor de busca
        return $this->serviceUser->getUsersQuestionsResume($questionIds)->filter(function ($userQuestion) {
            // Faça a comparação com base no critério de busca
            return stripos($userQuestion->name, $this->search) !== false;
        });
    }

    // Caso contrário, retorne todos os dados
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
        $this->validate([
            'type' => 'required',
            'title' => 'required',
            'options.*.text' => 'required_if:type,multi',
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

        $this->service->store($request);

        $this->resetInputCreate();

        session()->flash('message', 'A pergunta foi salva com sucesso!');
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
            $this->serviceResponse->store([
                'user_id' => Auth::user()->id,
                'question_id' => $questionId,
                'response' => $answer,
            ]);
        }

        $this->resetInputAnswers();

        session()->flash('message', 'As respostas foram salvas com sucesso!');
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
}
