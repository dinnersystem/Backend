<?php
namespace json;

class json_adjust
{
    public static $black_list = [
        ',"ingre":[]' ,
        ',"valid_oper":[]'
    ];

    public static function adjust($data)
    {
        foreach(self::$black_list as $item)
        {
            $data = str_replace($item ,'' ,$data);
        }   
        return $data;
    }
}

?>