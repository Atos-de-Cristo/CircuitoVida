<?php
namespace App\Enums;

enum EventStatus: string {
    case P = "Pendente";
    case A = "Aberto";
    case E = "Encerrado";
    case F = "Finalizada";

    public static function fromValue(string $status): string {
        foreach (self::cases() as $statusClass) {
            if ($status === $statusClass->name) {
                return $statusClass->value;
            }
        }

        throw new \ValueError("$status não é válido");
    }
}
