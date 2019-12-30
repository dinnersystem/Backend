<?php
namespace other;

class date_api
{
    public static function is_valid_time($date ,$format = 'Y/m/d-H:i:s')
    {
        $date_obj = \DateTime::createFromFormat($format, $date);
        if($date_obj === false) throw new \Exception("Invalid format.");
        if($date_obj->getTimestamp() <= 0) throw new \Exception("Over unix timestamp.");
        return $date_obj;
    }

    public static function is_between($a ,$b ,$c ,$format = 'Y-m-d H:i:s')
    {
        $a = self::is_valid_time($a ,$format);
        $b = self::is_valid_time($b ,$format);
        $c = self::is_valid_time($c ,$format);
        if($a < $b && $b < $c) return true;
        else return false;
    }
}

?>