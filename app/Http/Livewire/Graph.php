<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Graph extends Component
{
    public $type;
    public $title;
    public $labels;
    public $data;
    public $datasets;
    public $options;

    public function mount($type, $title, $labels, $data, $datasets = [], $options = [])
    {
        $this->type = $type;
        $this->title = $title;
        $this->labels = $labels;
        $this->data = $data;
        $this->datasets = $datasets;
        $this->options = $options;
    }

    public function render()
    {
        return view('livewire.shared.graph');
    }

    public function chartUpdated($type, $title, $labels, $data, $datasets = [], $options = [])
    {
        $this->emit('chartUpdated', [
            'type' => $type,
            'title' => $title,
            'labels' => $labels,
            'data' => $data,
            'datasets' => $datasets,
            'options' => $options,
        ]);
    }
}
