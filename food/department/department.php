<?php
namespace food;

use json\json_format;
use json\json_output;

class department implements json_format
{
    public $id;
    public $name;
    public $factory;
    
    public function __construct($id ,$name ,$factory)
    {
        $this->id = $id;
        $this->name = $name;
        $this->factory = $factory;
    }
    
    public function get_json()
    {
        $json = 
            '{"name":"' . json_output::filter($this->name) .
            '","id":"' . json_output::filter($this->id) . '"' .
            ',"factory":' . $this->factory->get_json() . '}';
        return $json;
    }

    public function __clone() {
        $this->id = $this->id;
        $this->name = $this->name;
        $this->factory = clone $this->factory;
    }
}

?>