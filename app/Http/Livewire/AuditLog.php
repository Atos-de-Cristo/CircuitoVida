<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Services\AuditService;
use Livewire\Component;
use OwenIt\Auditing\Models\Audit;

class AuditLog extends Component
{
    public $type = '';
    public $userId = '';
    public $module = '';

    public function render()
    {
        $users = User::all();

        $models = AuditService::getAuditableModels();

        $audits = Audit::query()
            ->with('user')
            ->where(function ($query) {
                $query
                    ->where('event', 'like', '%' . $this->type . '%')
                    ->where('user_id', 'like', '%' . $this->userId . '%')
                    ;
            })
            ->when($this->module, function ($query) {
                $query->where('auditable_type', $this->module);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.shared.audit-log', compact('audits', 'users', 'models'));
    }
}
