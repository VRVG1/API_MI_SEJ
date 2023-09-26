<?php

namespace App\Enums;

enum Yes_No: string
{
    case Si = "Si";
    case No = "No";

    /**
     * Lista todos los valores del enum
     * @return string
     */
    public static function getValues()
    {
        // Retorna los valores del enum como un string
        $cases_enum = self::cases();
        $string_pretty = '[ ';
        foreach ($cases_enum as $case) {
            $string_pretty .= $case->value . ', ';
        }
        $string_pretty = substr($string_pretty, 0, -2);
        $string_pretty .= ' ]';
        return $string_pretty;
    }
}