<?php
namespace food;

use json\json_output;
use json\json_format;

class dish extends limitable implements json_format
{
    public $id;
    public $name;
    public $charge;
    public $vege;
    public $department;
    public $is_idle;
    public $best_seller;
    
    public function __construct($id ,$name ,$charge ,$is_idle ,$department ,$is_vege)
    {
        $this->id = $id;
        $this->name = $name;
        $this->charge = $charge;
        $this->is_idle = $is_idle;
        $this->department = $department;
        $this->vege = $is_vege;

        if(array_key_exists($department->factory->id ,best_seller())) {
            $seller = best_seller()[$department->factory->id];
            foreach($seller as $part)
                $this->best_seller |= (strpos($name, $part) !== false);
        }
    }
    
    public function get_json()
    {
        $json = 
            '{"dish_name":"' . json_output::filter($this->name) .
            '","dish_id":"' . json_output::filter($this->id) . 
            '","vege":' . $this->vege->get_json() . 
            ',"department":' . $this->department->get_json() . 
            ',"dish_cost":"' . json_output::filter($this->charge) .
            '","daily_produce":"' . json_output::filter($this->limit) .
            '","best_seller":"' . ($this->best_seller ? "true" : "false") .
            '","remaining":"' . json_output::filter($this->get_remaining()) .
            '","is_idle":"' . json_output::filter($this->is_idle) . '"}';
        return $json;
    }

    public function updatable()
    {
        return updatable($this->department->factory->id);
    }

    public function __clone() {
        $this->id = $this->id;
        $this->name = $this->name;
        $this->charge = $this->charge;
        $this->is_idle = $this->is_idle;
        $this->department = clone $this->department;
        $this->clone_limitable();
    }
}

?>