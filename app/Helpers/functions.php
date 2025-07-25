<?php

use App\Enums\{EventStatus, EventType, InscriptionStatus};

if (!function_exists('getStatusEvent')) {
    function getStatusEvent(string $status): string {
        return EventStatus::fromValue($status);
    }
}

if (!function_exists('getTypeEvent')) {
    function getTypeEvent(string $status): string {
        return EventType::fromValue($status);
    }
}

if (!function_exists('getStatusInscription')) {
    function getStatusInscription(string $status): string {
        return InscriptionStatus::fromValue($status);
    }
}
