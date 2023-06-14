<?php

namespace App\Http\Livewire;

use App\Services\ResponseService;
use Livewire\Component;

class EventActivityQuestionCorrect extends Component
{
    private $serviceResponse;
    public $userId, $atvId;

    protected $listeners = [
        'refreshActivityQuestionCheck' => '$refresh'
    ];

    public function __construct()
    {
        $this->serviceResponse = new ResponseService;
    }

    public function mount($userId, $atvId)
    {
        $this->userId = $userId;
        $this->atvId = $atvId;
    }

    public function getQuestionsProperty()
    {
        return $this->serviceResponse->getUserQuestionResponse($this->userId, $this->atvId);
    }

    public function render()
    {
        return view('livewire.event.activity.question-correct');
    }

    public function closeCorrectAnswers()
    {
        $this->emit('closeCorrectAnswers');
    }

    public function checkQuestion(string $status, string $idResponse)
    {
        $this->serviceResponse->update(array('status' => $status), $idResponse);
    }
}
