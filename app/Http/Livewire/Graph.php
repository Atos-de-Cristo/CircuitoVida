<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Graph extends Component
{
    public $code;
    public $type;
    public $title;
    public $labels;
    public $values;

    public function render()
    {
        return view('livewire.shared.graph');
    }
}
