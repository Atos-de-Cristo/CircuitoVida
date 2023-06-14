<?php

namespace App\Http\Livewire;

use App\Services\PermissionService;
use App\Services\UserService;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;

    public $_id, $name, $email, $password, $permissionData, $permissions;
    public $isOpen = false;
    protected $service;

    public $search = '';



    protected $rules = [
        'name' => 'required|min:5',
        'email' => 'required|email',
    ];

    protected $messages = [
        'name.required' => 'Nome é obrigatório.',
        'name.min' => 'Nome precisa ter no mínimo :min caracteres',
        'email.required' => 'E-mail é obrigatório.',
        'email.email' => 'E-mail não é um campo valido',
    ];

    public function mount(PermissionService $permissionService)
    {
        $this->fill([
            'permissionData' => $permissionService->getAll()
        ]);
    }

    public function render(UserService $service)
    {
        $dataAll = $service->paginate($this->search);
        return view('livewire.user.index', compact('dataAll'));
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->resetInputFields();
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->_id = '';
        $this->name = '';
        $this->email = '';
        $this->permissions = [];
    }

    public function store(UserService $service)
    {
        $this->validate();

        $request = [
            'name' => $this->name,
            'email' => $this->email,
            'permissions' => $this->permissions,
            'password' => $this->password
        ];

        if ($this->_id) {
            $service->update($request, $this->_id);
        }else{
            $service->create($request);
        }

        session()->flash('message',
            $this->_id ? 'Usuário editado com sucesso.' : 'Usuário cadastrado com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id, UserService $service)
    {
        $user = $service->find($id);
        $this->_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        //TODO: melhorar consulta relacionamentos
        $this->permissions = explode(',', $user->permissions()->implode('id', ','));

        $this->openModal();
    }

    public function delete($id, UserService $service)
    {
        $service->delete($id);
        session()->flash('message', 'Evento deletado com sucesso.');
    }

    public function manager($id){
        redirect(route('userDetails', ['id' => $id]));
    }
}
