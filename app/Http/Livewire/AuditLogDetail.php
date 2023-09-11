<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AuditLogDetail extends Component
{
    public $old_values, $new_values;
    public $isOpenDif = false;

    public function render()
    {
        return view('livewire.audit.detail');
    }
}
