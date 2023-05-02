<?php

namespace App\Http\Livewire\Form;

use Livewire\Component;

class Text extends Component
{
    public $id;

    public function mount($form){
        $this->id = $form->id;
    }

    public function render()
    {
        return view('livewire.form.text');
    }
}
