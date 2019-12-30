<?php
namespace food;

use json\json_output;
use json\json_format;

class vege implements json_format
{
    public $number;
    public $name;

    public static $vege_adapt = [
        'PURE' => 2 ,
        'VEGE' => 1 ,
        'MEAT' => 0
    ];

    function __construct($number ,$name = null) {
        if($number === null && $name === null) {
            $this->number = -1;
            $this->name = "unknown";
        }

        if($number !== null && $name !== null) throw new \Exception();
        
        if($number === null && $name !== null) {
            $this->name = $name;
            if(self::$vege_adapt[$name] === null) throw new \Exception();
            $this->number = self::$vege_adapt[$name];
        }
        
        if($number !== null && $name === null) {
            $this->number = $number;
            $tmp = array_flip(self::$vege_adapt);
            if($tmp[$number] === null) throw new \Exception();
            $this->name = $tmp[$number];
        }
    }

    public function get_json() {
        return '{"number":"' . $this->number . '",' .
            '"name":"' . $this->name . '"}';
    }
}


?>