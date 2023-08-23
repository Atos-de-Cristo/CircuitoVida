<?php

namespace App\Policies;

class EventPolicy
{
    public function monitorEvent($user, $eventId)
    {
        return ($user->hasPermissionTo('monitor') && $user->monitors->pluck('id')->contains($eventId)) ?? false;
    }
}
