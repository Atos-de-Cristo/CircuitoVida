<?php

namespace App\Http\Livewire;

use App\Services\QuestionService;
use Illuminate\Http\Request;
use Livewire\Component;

class EventActivityQuestion extends Component
{
    public $atvId, $title;
    public $type = 'aberta';
    public $options = [];
    public $answers = [];

    protected $listeners = [
        'refreshActivityQuestion' => '$refresh'
    ];

    public function boot(Request $request)
    {
        $this->atvId = $request->id;
    }

    public function render(QuestionService $questionService)
    {
        $questions = $questionService->getAll($this->atvId);
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

    public function store(QuestionService $questionService)
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

        $questionService->create($request);

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
        // Validação das respostas
        $this->validate([
            'answers.*' => 'required',
        ]);

        // Salva as respostas no banco de dados
        // foreach ($this->answers as $questionId => $answer) {
        //     Answer::create([
        //         'question_id' => $questionId,
        //         'answer' => $answer,
        //     ]);
        // }

        $this->resetInputAnswers();

        session()->flash('message', 'As respostas foram salvas com sucesso!');
    }

    public function resetInputAnswers()
    {
        $this->type = 'aberta';
        $this->options = [];
        $this->title = '';
    }
}
