<?php

namespace App\Http\Livewire;

use App\Services\CategoryService;
use Livewire\Component;

class EventCategoryAdd extends Component
{
    public $categoryId, $name;
    public bool $isOpen = false;

    public function getCategoryServiceProperty()
    {
        return new CategoryService;
    }

    public function mount($id=null)
    {
        $this->categoryId = $id;

        if ($id) {
            $data = $this->categoryService->find($id);
            $this->name = $data->name;
        }
    }

    public function render()
    {
        return view('livewire.event.category.add');
    }

    private function resetInput()
    {
        $this->name = '';
    }

    public function store()
    {
        $request = [
            'name' => $this->name
        ];
        if ($this->categoryId) {
            $request['id'] = $this->categoryId;
        }
        $this->categoryService->store($request);
        $this->resetInput();
        $this->emit('refreshEventCategory');
    }

    public function del()
    {
        $this->categoryService->delete($this->categoryId);
        $this->emit('refreshEventCategory');
    }
}
