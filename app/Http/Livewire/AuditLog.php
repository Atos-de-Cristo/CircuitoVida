<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Services\AuditService;
use Livewire\Component;
use Livewire\WithPagination;
use OwenIt\Auditing\Models\Audit;

class AuditLog extends Component
{
    use WithPagination;

    public $type = '';
    public $userId = '';
    public $module = '';

    public function getServiceProperty()
    {
        return new AuditService;
    }

    public function render()
    {
        $users = User::all();

        $models = $this->service->getAuditableModels();

        $audits = $this->service->getAll([
            'type' => $this->type,
            'userId' => $this->userId,
            'module' => $this->module
        ]);

        return view('livewire.audit.log', compact('audits', 'users', 'models'));
    }
}
