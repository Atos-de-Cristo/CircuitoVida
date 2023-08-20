<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VideoManager extends Component
{
    public $videoId, $videoDuration, $currentTime;
    public $videoState = 'nao iniciado';
    public $videoTime = null;

    protected $listeners = [
        'playerStateChanged' => 'onPlayerStateChange',
        'onPlayerReady' => 'onPlayerReady',
    ];

    public function render()
    {
        return view('livewire.event.classroom.video-manager');
    }

    public function onPlayerStateChange($state)
    {
        $this->videoState = $state;
    }

    public function onPlayerReady($time)
    {
        $this->videoDuration = $time;
    }
}
