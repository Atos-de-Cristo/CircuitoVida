<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VideoPlayer extends Component
{
    public $videoId;
    public $playerId = 'youtube-player';

    public function render()
    {
        return view('livewire.event.classroom.video-player');
    }
}
