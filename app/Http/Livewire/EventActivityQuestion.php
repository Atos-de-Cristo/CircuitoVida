<?php

namespace App\Http\Livewire;

use App\Services\QuestionService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EventActivityQuestion extends Component
{
    public $atvId, $title;
    public $type = 'aberta';
    public $options = [];
    public $answers = [];
    private $service, $serviceResponse;

    protected $listeners = [
        'refreshActivityQuestion' => '$refresh'
    ];

    public function __construct()
    {
        $this->service = new QuestionService;
        $this->serviceResponse = new ResponseService;
    }

    public function mount(Request $request)
    {
        $this->atvId = $request->id;
    }

    public function render()
    {
        $questions = $this->service->getAll($this->atvId);
        return view('livewire.event.activity.question', compact('questions'));
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

        $this->service->create($request);

        $this->resetInputCreate();

        session()->flash('message', 'A pergunta foi salva com sucesso!');
    }

    public function resetInputCreate()
    {
        $this->type = 'aberta';
        $this->options = [];
        $this->title = '';
    }

    public function storeQuestion()
    {
        $this->validate([
            'answers.*' => 'required',
        ]);

        foreach ($this->answers as $questionId => $answer) {
            $this->serviceResponse->create([
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
}
