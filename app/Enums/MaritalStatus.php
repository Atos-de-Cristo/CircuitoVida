<?php
namespace App\Enums;

enum MaritalStatus: string {
    case S = "Solteiro (a)";
    case N = "Noivo (a)";
    case C = "Casado (a)";
    case U = "União Estável";
    case V = "Viúvo (a)";
    case D = "Divorciado (a)";

    public static function fromValue(string $status): string {
        foreach (self::cases() as $statusClass) {
            if ($status === $statusClass->name) {
                return $statusClass->value;
            }
        }

        throw new \ValueError("$status não é válido");
    }
}
