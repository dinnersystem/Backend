<?php
namespace order\money_info;

use json\json_output;
use json\json_format;

class payment implements json_format
{
    public $id;
    public $paid;
    
    public $able_dt;
    public $paid_dt;
    public $freeze_dt;
    
    public $name;

    public $reversable;
    
    function __construct($id ,$paid ,$able_dt ,$paid_dt ,$freeze_dt ,$name ,$reversable)
    {
        $this->id = $id;
        $this->paid = $paid;
        $this->able_dt = $able_dt;
        $this->paid_dt = $paid_dt;
        $this->freeze_dt = $freeze_dt;
        $this->name = $name;
        $this->reversable = $reversable;
    }
    
    public function get_json()
    {
        $data = 
             '{"id":"' . json_output::filter($this->id) . 
             '","paid":"' . ($this->paid ? 'true' : 'false') . 
             '","able_dt":"' . json_output::filter($this->able_dt) . 
             '","paid_dt":"' . json_output::filter($this->paid_dt) . 
             '","freeze_dt":"' . json_output::filter($this->freeze_dt) . 
             '","name":"' . json_output::filter($this->name) .
             '","reversable":"' . json_output::filter($this->reversable) . '"}';
         return $data;
    }

    public function __clone() {
        $this->id = $this->id;
        $this->paid = $this->paid;
        $this->able_dt = $this->able_dt;
        $this->paid_dt = $this->paid_dt;
        $this->freeze_dt = $this->freeze_dt;
        $this->name = $this->name;
        $this->reversable = $this->reversable;
    }
}

?>