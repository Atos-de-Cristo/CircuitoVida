<?php

namespace App\Http\Livewire;

use App\Services\PermissionService;
use App\Services\UserService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;

    public $_id, $name, $email, $password, $permissionData, $permissions;
    public $isOpen = false;
    protected $service;

    public $search = '';

    public function search()
    {
        $this->resetPage();
    }

    protected $rules = [
        'name' => 'required|min:5',
        'email' => 'required|email|unique:users,email',
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
        $this->isOpen = true;
    }

    public function close()
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
        try{
            $request = [
                'name' => $this->name,
                'email' => $this->email,
                'permissions' => array_filter($this->permissions),
                'password' => $this->password
            ];

            if ($this->_id) {
                $service->update($request, $this->_id);
            }else{
                $this->validate();
                $service->create($request);
            }
            session()->flash('message', [
                'text' =>  $this->_id ? 'Usuário editado com sucesso.' : 'Usuário cadastrado com sucesso.',
                'type' => 'success',
            ]);

            $this->isOpen = false;
            $this->resetInputFields();
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();

            $this->resetErrorBag();

            foreach ($errors->messages() as $field => $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $this->addError($field, $error);
                }
            }
        }
    }

    public function edit($id, UserService $service)
    {
        $user = $service->find($id);
        $this->_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        //TODO: melhorar consulta relacionamentos
        $this->permissions = explode(',', $user->permissions()->implode('id', ','));

        $this->isOpen = true;
    }

    public function delete($id, UserService $service)
    {
        $service->delete($id);

        session()->flash('message', [
            'text' => 'Usuário deletado com sucesso.' ,
            'type' => 'success',
        ]);

    }

    public function manager($id){
        redirect(route('userDetails', ['id' => $id]));
    }
}
