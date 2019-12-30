<?php
namespace json;


class json_output
{
    public static $filter_string =
        ['\\' => '\\\\' ,
          '"' => '\"'];
    
    public static function filter($string)
    {
        foreach(self::$filter_string as $key => $value)
            $string = str_replace($key ,$value ,$string);
            
        return $string;
    }
    
    public static function array_to_json($var)
    {
        $json = "[";
        $has_run = false;
        $counter = 1;
        
        if(gettype($var) != "array") {
            throw new \Exception("This is not an array.");
        } else {
            foreach ($var as $value)
            {
                if ($has_run == true)
                    $json .= ',';
                else
                    $has_run = true;
                
                if (gettype($value) == "object" && class_implements($value)['json\\json_format'] == 'json\\json_format')
                {
                    $obj_data = $value->get_json();
                    $json .= $obj_data;
                } 
                else if(is_array($value))
                {
                    $json .= self::array_to_json($value);
                }
                else{
                    $json .= '"' . self::filter($value) . '"';
                }
            }
        }

        $json .= "]";
        return $json;
    }

    public static function output($var)
    {
        $json = '';
        if (is_array($var))
            $json .= json_output::array_to_json($var);
        else
        {
            if (class_implements($var)['json\\json_format'] == 'json\\json_format')
                $json .= $var->get_json();
            else
                $json .= "{}";
        }
        
        return json_adjust::adjust($json);
    }
}

?>