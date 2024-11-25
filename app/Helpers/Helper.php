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
            $system_date_format = 'jS M, Y';
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
