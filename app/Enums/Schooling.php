<?php
namespace App\Enums;

enum Schooling: string {
    case FI = "Ensino Fundamental Incompleto";
    case FC = "Ensino Fundamental Completo";
    case MI = "Ensino Médio Incompleto";
    case MC = "Ensino Médio Completo";
    case TI = "Ensino Técnico Incompleto";
    case TC = "Ensino Técnico Completo";
    case SI = "Ensino Superior Incompleto";
    case SC = "Ensino Superior Completo";
    case E = "Especialização";
    case M = "Mestrado";
    case D = "Doutorado";
    case P = "Pós-Doutorado";
    case EF = "Ensino Fundamental (1º ao 9º ano)";
    case EM = "Ensino Médio";
    case EI = "Educação Infantil";
    case A = "Alfabetização de Adultos";
    case EJ = "Educação de Jovens e Adultos (EJA)";

    public static function fromValue(string $status): string {
        foreach (self::cases() as $statusClass) {
            if ($status === $statusClass->name) {
                return $statusClass->value;
            }
        }

        throw new \ValueError("$status não é válido");
    }
}
