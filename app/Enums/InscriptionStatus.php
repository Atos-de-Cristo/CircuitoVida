<?php
namespace App\Enums;

enum InscriptionStatus: string {
    case P = "Pendente";
    case L = "Liberado";
    case A = "Aprovado";
    case R = "Reprovado";
    case G = "Pago";
    case C = "Cancelado";
    case I = "Iniciado";
    case F = "Finalizado";

    public static function fromValue(string $status): string {
        foreach (self::cases() as $statusClass) {
            if ($status === $statusClass->name) {
                return $statusClass->value;
            }
        }

        throw new \ValueError("$status não é válido");
    }
}
