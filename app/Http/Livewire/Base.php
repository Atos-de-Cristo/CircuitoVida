<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Base extends Component
{
    public $form = [];

    public function setErrorMessages($errors)
    {
        foreach ($errors->messages() as $field => $fieldErrors) {
            if (isset($this->form[$field])) {
                foreach ($fieldErrors as $error) {
                    $this->addError('form.'.$field, $error);
                }
            }else{
                Session::flash('message', $fieldErrors);
            }
        }
    }

    public function resetErrors()
    {
        $this->resetErrorBag();
    }
}
