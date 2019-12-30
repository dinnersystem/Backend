<?php
namespace order;

use json\json_output;
use json\json_format;
use food\dish;
use food\department;
use food\vege;

class order implements json_format
{
    public $id;
    public $user;
    public $order_maker;
    public $money;
    public $esti_recv;

    public $buffet;
    public $dish;
    
    public function __construct($id , $user, $order_maker, $recv_date ,$money)
    {
        $this->id = $id;
        $this->user = $user;
        $this->order_maker = $order_maker;
        $this->esti_recv = $recv_date;
        $this->money = $money;
        $this->dish = [];
    }

    public function init_buffet($buffet ,$history)
    {
        $this->buffet = $buffet;
        $sum = 0;
        foreach($buffet as $b)
        {
            $this->dish[] = ($history ? $b->dish : $b->dish->id);
            $sum += $b->dish->charge;
        }

        if(count($buffet) > 1) {
            //all the ingredients must be from the same factory.
            $this->vdish = new dish(-1 ,"自助餐" ,$sum ,false ,
                new department(-1 ,"自助部門" ,
                    clone reset($buffet)->dish->department->factory
                ),
                new vege(0) ,-1);
        } else {
            $this->vdish = reset($buffet)->dish;
        }
    }
    
    public function get_json()
    {
         $data = 
             '{"id" : "' . json_output::filter($this->id) . 
             '","user" : ' . $this->user->get_json() . 
             ',"order_maker" : ' . $this->order_maker->get_json() . 
             ',"dish" : ' . json_output::array_to_json($this->dish) .  
             ',"money" : ' . $this->money->get_json() . 
             ',"recv_date" : "' . json_output::filter($this->esti_recv) . '"}';
         return $data;
    }

}
?>