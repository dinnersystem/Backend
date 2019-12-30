<?php
namespace food;

class buffet
{
    public $id;
    public $dish;
    public $order;

    public function __construct($id ,$dish ,$order)
    {
        $this->id = $id;
        $this->dish = $dish;
        $this->order = $order;
    }

    public function get_json()
    {
        $data = 
             '{"id" : "' . json_output::filter($this->id) . 
             '","dish" : "' . json_output::filter($this->dish) . '"}';
         return $data;
    }
}

?>