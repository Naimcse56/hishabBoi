<?php

use Carbon\Carbon;


if (!function_exists('gv')) {
    function gv($params, $key, $default = NULL)
    {
        return (isset($params[$key]) && $params[$key]) ? $params[$key] : $default;
    }
}

if (!function_exists('carbonDate')) {
    function carbonDate($data, $format = 'd-m-Y')
    {
        if($data){
            $data = Carbon::parse($data);
            return $data->format($format);
        }else{
            return NULL;
        }
    }
}

if (!function_exists('carbonDateByDayMonthYear')) {
    function carbonDateByDayMonthYear($data, $format = 'd-m-Y')
    {
        if($data){
            $data = Carbon::createFromFormat('d/m/Y',$data);
            return $data->format($format);
        }else{
            return NULL;
        }
    }
}


if (!function_exists('showDateFormat')) {
    function showDateFormat($input_date){
        try {
            $system_date_format = app('general_setting')['date_format'];
            return date_format(date_create($input_date), $system_date_format);
        } catch (\Exception $th) {
            return $input_date;
        }
    }
}

if (!function_exists('showDefaultImage')) {
    function showDefaultImage($path) : string
    {
        if($path && file_exists($path)){
            return asset($path);
        }else{
            return asset('images/uploadDefault.png');
        }
    }
}

if (!function_exists('currencySymbol')) {
    function currencySymbol($amount)
    {
        return app('general_setting')['system_currency_symbol'].number_format(floatval($amount), 2);
    }
}

if (!function_exists('convert_number')) {
    function convert_number($number = false)
    {
        $my_number = $number;

        if (($number < 0) || ($number > 99999999999)) 
        { 
        throw new Exception("Number is out of range");
        } 
        $Kt = floor($number / 10000000); /* Koti */
        $number -= $Kt * 10000000;
        $Gn = floor($number / 100000);  /* lakh  */ 
        $number -= $Gn * 100000; 
        $kn = floor($number / 1000);     /* Thousands (kilo) */ 
        $number -= $kn * 1000; 
        $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
        $number -= $Hn * 100; 
        $Dn = floor($number / 10);       /* Tens (deca) */ 
        $n = $number % 10;               /* Ones */ 

        $res = ""; 

        if ($Kt) 
        { 
            $res .= convert_number($Kt) . " Crore "; 
        } 
        if ($Gn) 
        { 
            $res .= convert_number($Gn) . " Lakh"; 
        } 

        if ($kn) 
        { 
            $res .= (empty($res) ? "" : " ") . 
                convert_number($kn) . " Thousand"; 
        } 

        if ($Hn) 
        { 
            $res .= (empty($res) ? "" : " ") . 
                convert_number($Hn) . " Hundred"; 
        } 

        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
            "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
            "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
            "Nineteen"); 
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
            "Seventy", "Eigthy", "Ninety"); 

        if ($Dn || $n) 
        { 
            if (!empty($res)) 
            { 
                $res .= " and "; 
            } 

            if ($Dn < 2) 
            { 
                $res .= $ones[$Dn * 10 + $n]; 
            } 
            else 
            { 
                $res .= $tens[$Dn]; 

                if ($n) 
                { 
                    $res .= "-" . $ones[$n]; 
                } 
            } 
        } 

        if (empty($res)) 
        { 
            $res = "zero"; 
        } 

        return $res; 
    }
}
