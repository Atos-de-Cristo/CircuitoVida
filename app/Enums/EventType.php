<?php
namespace App\Enums;

enum EventType: string {
    case P = "Palestra";
    case C = "Curso";
    case G = "Congresso";
    case R = "Retiro";

    public static function fromValue(string $status): string {
        foreach (self::cases() as $statusClass) {
            if ($status === $statusClass->name) {
                return $statusClass->value;
            }
        }

        throw new \ValueError("$status não é válido");
    }
}
