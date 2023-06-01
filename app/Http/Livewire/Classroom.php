<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Classroom extends Component
{
    public $videoUrl = 'https://www.youtube.com/embed/8Kjhr_8MmU0';
    public $materials = [
        'Material 1' => '/path/to/material1.pdf',
        'Material 2' => '/path/to/material2.pdf',
    ];
    public $activities = [
        'Atividade 1' => '/path/to/activity1.pdf',
        'Atividade 2' => '/path/to/activity2.pdf',
    ];

    public function render()
    {
        return view('livewire.event.classroom');
    }
}
