<?php
namespace user;

use json\json_output;
use json\json_format;

class user implements json_format
{
    public $id;
    public $name;
    public $class;
    public $seat_no;

    public $login_id;
    public $password;
    public $bank_id;
    public $is_vege;
    public $prev_sum = 0;
    public $PIN;
    public $daily_limit;

    public $money;
    public $card;

    public $services = [];
    public $prev = [];
    public $services_output = [];
    
    function __construct($usr_id ,$name ,$class ,$seat_no)
    {
        $this->id = $usr_id;
        $this->name = $name;
        $this->class= $class;
        $this->seat_no = $seat_no;
        $this->is_vege = new \food\vege(null ,null);
    }
    
    public function full_init()
    {
        $services = \user\get_able_oper($this->prev_sum);
        $prev = \user\previleges::get_prevs($this->prev_sum);
        $this->services = $services;
        $this->prev = $prev;
        foreach($services as $key => $value) 
            $this->services_output[] = $key;
    }

    public function private_init($prev_sum ,$vege ,$login_id ,$bank_id ,$password ,$PIN ,$daily_limit ,$data_collected)
    {
        $this->prev_sum = $prev_sum;
        $this->is_vege = $vege;
        $this->login_id = $login_id;
        $this->bank_id = $bank_id;
        $this->password = $password;
        $this->PIN = $PIN;
        $this->daily_limit = $daily_limit;
        $this->data_collected = $data_collected;
        $this->full_init();
    }

    public function pos_init($money ,$card)
    {
        $this->money = $money;
        $this->card = $card;
    }

    public static function get_guest()
    {
        $user = new user(null ,null ,null ,null);
        $user->prev_sum = 1;
        $user->full_init();
        return $user;
    }
    
    public function get_json()
    {
        $data = 
            '{"id":"' . json_output::filter($this->id) . 
            '","name":"' . json_output::filter($this->name) .
            '","daily_limit":"' . json_output::filter($this->daily_limit) .
            '","vege":' . $this->is_vege->get_json() .
            ',"class":' . $this->class->get_json() .
            ',"seat_no":"' . json_output::filter($this->seat_no) .
            '","prev_sum":"' . json_output::filter($this->prev_sum) .
            '","money":"' . json_output::filter($this->money) .
            '","card":"' . json_output::filter($this->card) .
            '","data_collected":"' . ($this->data_collected ? "1" : "0") .
            '","valid_oper":' . json_output::array_to_json($this->services_output) . '}';
        return $data;
    }
}

?>