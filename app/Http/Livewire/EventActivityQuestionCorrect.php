<?php

namespace App\Http\Livewire;

use App\Services\ResponseService;
use Livewire\Component;

class EventActivityQuestionCorrect extends Component
{
    public $userId, $atvId;
    public $checkResponse = [];
    public $feedback = [];

    public function getServiceResponseProperty()
    {
        return new ResponseService;
    }

    public function getQuestionsProperty()
    {
        return $this->serviceResponse->getUserQuestionResponse($this->userId, $this->atvId);
    }

    public function mount($userId, $atvId)
    {
        $this->userId = $userId;
        $this->atvId = $atvId;

        foreach ($this->questions as $item) {
            if ($item->question->type == 'multi') {
                $options = json_decode($item->question->options);
                $resp = $item->response;
                $opt = array_values(array_filter($options, function($value) use ($resp) {
                    return $value->text == $resp;
                }));
                $itemStatus = array_shift($opt)->correct;
                $this->checkResponse[$item->id] = $itemStatus ? 'correto' : 'errado';
            }
            $this->feedback[$item->id] = $item->feedback;
        }
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
        $this->checkResponse[$idResponse] = $status;
    }

    public function store()
    {
        foreach ($this->checkResponse as $id => $status) {
            $this->serviceResponse->store(array(
                'id' => $id,
                'status' => $status,
                'feedback' => $this->feedback[$id] ?? null
            ));
        }
        $this->closeCorrectAnswers();
    }
}
