<?php

namespace App\Lib;

use DateTime;

class Auxiliar
{
    public static function converterDataParaBR($data_USA){                
        $date = new DateTime($data_USA);      
        return $date->format('d/m/Y');       
    }
    
    public static function converterDataTimeBR($data_USA){                
        $date = new DateTime($data_USA);      
        return $date->format('d/m/Y H:i:s');       
    }
    
    public static function converterDataParaUSA($data_BRA){                        
        $d = explode('/', $data_BRA);
        $dOK = $d[2].'-'.$d[1].'-'.$d[0];
        return $dOK;     
    }

    public static function obterAnos(){
        return ['2018','2019', '2020', '2021', '2022', '2023', '2024', '2025'];
    }
}