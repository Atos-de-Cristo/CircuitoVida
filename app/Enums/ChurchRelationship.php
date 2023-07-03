<?php
namespace App\Enums;

enum ChurchRelationship: string {
    case M = "Sou membro da igreja";
    case E = "Estou a caminho para virar membro";
    case V = "Visito a igreja";
    case N = "Nunca visitei, mas tenho vontade";

    public static function fromValue(string $status): string {
        foreach (self::cases() as $statusClass) {
            if ($status === $statusClass->name) {
                return $statusClass->value;
            }
        }

        throw new \ValueError("$status não é válido");
    }
}
