<?php

namespace App\Enum;

class Trimestres {
    public static function descricao($id){
        $trimestre = "";
        switch($id){
            case 1: 
                $trimestre = "1º Trimestre";
                break;
            case 2: 
                $trimestre = "2º Trimestre";
                break;
            case 3: 
                $trimestre = "3º Trimestre";
                break;
            default:
                $trimestre = "";
        }

        return $trimestre;
    } 
}