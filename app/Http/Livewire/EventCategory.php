<?php

namespace App\Http\Livewire;

use App\Services\CategoryService;
use Livewire\Component;

class EventCategory extends Component
{
    protected $listeners = ['refreshEventCategory' => '$refresh'];


    public function getCategoryServiceProperty()
    {
        return new CategoryService;
    }

    public function getCategoriesProperty()
    {
        return $this->categoryService->getAll();
    }

    public function render()
    {
        return view('livewire.event.category.list');
    }
}
