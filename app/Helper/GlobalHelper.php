<?php 

use Illuminate\Support\Str;

function renderResponse($result = null, $status)
{
    if(is_bool($status)){
        $status = 400;        
        if($status){
            $status = 200;
        }
    }
    return response()->json($result, $status);
}

 function object_to_array($data)
    {
        if (is_array($data) || is_object($data))
        {
            $result = array();
            foreach ($data as $key => $value)
            {
                $result[$key] = object_to_array($value);
            }
            return $result;
        }
        return $data;
    }

function get_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

 function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

function inputToLower($input,$excep = array())
{
    foreach ($input as $k => $v) {
        if (is_array($v)) {
            foreach ($v as $k2 => $v2) {
                if (is_array($v2)) {
                    $input[$k][$k2] = inputToLower($v2,$excep);
                } else {
                    $input[$k][$k2] = (in_array($k2,$excep) || $k2 == '_id') ? $v2 : strtolower($v2) ;
                }
            }
        } else {
            $input[$k] = (in_array($k,$excep) || $k == '_id') ? $v : strtolower($v) ;
        }
    }

    return $input;
}

function extractInputJson($input)
{
    $result = [];
    foreach ($input as $k => $v) {
        if (is_array($v)) {
            foreach ($v as $k2 => $v2) {
                $result[$k2] = $v2;
            }
        } else {
            $result[$k] = $v;
        }
    }

    return $result;
}

function isSameOrganization($token)
{
}

function handlingErrorMessages($error)
{
    $message = '';
    foreach ($error as $k => $v) {
        $message .= $v[0].' ';
    }

    return $message;
}

function ifunsetempty($arr, $key, $default) {
        return !isset($arr[$key]) || empty($arr[$key]) || $arr[$key]=='undefined' ? $default : $arr[$key];
}