<?php

namespace App\Http\Livewire;

use App\Services\UserService;
use Laravel\Fortify\Rules\Password;
use Livewire\Component;
use Livewire\WithPagination;
class User extends Component
{
    use WithPagination;

    public $_id, $name, $email, $password, $confirmed;
    public $isOpen = false;
    protected $service;

    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';


    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render(UserService $service)
    {
        $dataAll = $service->paginate($this->search,$this->sortBy, $this->sortDirection);
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
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->_id = '';
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->confirmed = '';
    }

    public function store(UserService $service)
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password, 'confirmed'],
        ]);

        $request = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];

        if ($this->_id) {
            $service->update($request, $this->_id);
        }else{
            $service->create($request);
        }

        session()->flash('message',
            $this->_id ? 'Evento editado com sucesso.' : 'Evento cadastrado com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id, UserService $service)
    {
        $event = $service->find($id);
        $this->_id = $event->id;
        $this->name = $event->name;
        $this->email = $event->email;
        $this->password = $event->password;
        $this->confirmed = $event->confirmed;

        $this->openModal();
    }

    public function delete($id, UserService $service)
    {
        $service->delete($id);
        session()->flash('message', 'Evento deletado com sucesso.');
    }
}
