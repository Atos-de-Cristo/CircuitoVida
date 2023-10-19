<?php
namespace App\Enums;

enum InscriptionStatus: string {
    case P = "Pendente";
    case L = "Liberado";
    case A = "Aprovado";
    case R = "Reprovado";
    case C = "Cancelado";
    case F = "Finalizado";
    case T = "Transferido";

    public static function fromValue(string $status): string {
        foreach (self::cases() as $statusClass) {
            if ($status === $statusClass->name) {
                return $statusClass->value;
            }
        }

        throw new \ValueError("$status não é válido");
    }
}
