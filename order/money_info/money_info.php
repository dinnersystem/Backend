<?php
namespace order\money_info;

use json\json_output;
use json\json_format;

class money_info implements json_format
{
    public $id;
    public $charge;
    public $payment;
    
    function __construct($id ,$charge)
    {
        $this->id = $id;
        $this->charge = $charge;
        $this->payment = array();
    }

    public function init_payment($payment)
    {
        $this->payment = $payment;
    }
    
    public function get_json()
    {
        $data = 
            '{"id":"' . json_output::filter($this->id) . 
            '","charge":"' . json_output::filter($this->charge) .
            '","payment":' . json_output::array_to_json($this->payment) . '}';
        return $data;
    }
}

?>