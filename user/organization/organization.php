<?php
namespace user;

use json\json_output;
use json\json_format;

class organization implements json_format
{
    function __construct($id ,$name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    
    public function get_json()
    {
        return '{"id":"' . json_output::filter($this->id) . 
               '","name":"' . json_output::filter($this->name) . '"}';
    }
}

?>
