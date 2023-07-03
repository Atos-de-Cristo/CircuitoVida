<?php
namespace App\Enums;

enum HouMeet: string {
    case B = "Batismo: fui batizado(a) na igreja";
    case T = "Transferência: me tranferi de uma igreja de outra denominação";
    case R = "Reconciliação: estava afastado e voltei para a igreja";
    case J = "Jurisdição: vim de outra igreja da mesma denominação";
    case A = "Aclamação: fui batizado(a) em outra igreja";

    public static function fromValue(string $status): string {
        foreach (self::cases() as $statusClass) {
            if ($status === $statusClass->name) {
                return $statusClass->value;
            }
        }

        throw new \ValueError("$status não é válido");
    }
}
