<?php

namespace App\Http\Livewire;

use App\Services\{FrequencyService, VideoControlService};
use Illuminate\Support\Facades\{Auth, Session};
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Exception;

class VideoManager extends Base
{
    public $lesson, $videoDuration, $eventId;
    // public $videoState = 'nao iniciado';
    public $videoController;
    public $timeInit = null;
    public $timeTotal = 0;

    protected $listeners = [
        'playerStateChanged' => 'onPlayerStateChange',
        'onPlayerReady' => 'onPlayerReady',
    ];

    public function getServiceProperty()
    {
        return new VideoControlService;
    }

    public function getFrequencyServiceProperty()
    {
        return new FrequencyService();
    }

    public function render()
    {
        return view('livewire.event.classroom.video-manager');
    }

    public function onPlayerStateChange($state)
    {
        try {
            if ($state == '01') {
                $this->timeInit = Carbon::now();
            }
            if ($state == '02') {
                $timePause = Carbon::now();
                $this->timeTotal += $timePause->diffInSeconds($this->timeInit);

                $this->service->store([
                    'id' => $this->videoController->id,
                    'time_assisted' => $this->timeTotal
                ]);
            }
            if ($state == '03' && $this->timeTotal > 0) {
                $timePause = Carbon::now();
                $this->timeTotal += $timePause->diffInSeconds($this->timeInit);
                if ($this->timeTotal < $this->videoDuration) {
                    Session::flash('message', [
                        'text' => 'Necessário assistir video completo para registrar presença',
                        'type' => 'error',
                    ]);
                    return;
                }

                $this->service->store([
                    'id' => $this->videoController->id,
                    'time_assisted' => $this->timeTotal
                ]);

                $this->frequencyService->create([
                    'user_id' => Auth::user()->id,
                    'inscription_id' => Auth::user()->inscriptions->firstWhere('event_id', $this->eventId)->id,
                    'event_id' => $this->eventId,
                    'lesson_id' => $this->lesson->id,
                ]);

                Session::flash('message', [
                    'text' => 'Presença Registrada!',
                    'type' => 'success',
                ]);
            }
        } catch (ValidationException $e) {
            $this->setErrorMessages($e->validator->errors());
        } catch (Exception $e) {
            Session::flash('message', $e->getMessage());
        }
    }

    public function onPlayerReady($time)
    {
        try {
            $this->videoController = $this->service->store([
                'user_id' => Auth::user()->id,
                'lesson_id' => $this->lesson->id,
                'time_video' => $time,
            ]);
            $this->timeTotal = $this->videoController->time_assisted;
            $this->videoDuration = $time;
        } catch (ValidationException $e) {
            $this->setErrorMessages($e->validator->errors());
        } catch (Exception $e) {
            Session::flash('message', $e->getMessage());
        }
    }
}
