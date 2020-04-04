<?php
namespace food;

use json\json_output;
use json\json_format;

class factory extends limitable implements json_format
{
    public function __construct(
        $id ,
        $name ,
        $lower_bound ,
        $prepare_time ,
        $upper_bound ,
        $avail_lower_bound ,
        $avail_upper_bound ,
        $payment_time,
        $boss,
        $allow_custom,
        $minimum,
        $pos_id
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->lower_bound = str_replace(".0", "", $lower_bound);
        $this->prepare_time = str_replace(".0", "", $prepare_time);
        $this->upper_bound = str_replace(".0", "", $upper_bound);
        $this->avail_lower_bound = str_replace(".0", "", $avail_lower_bound);
        $this->avail_upper_bound = str_replace(".0", "", $avail_upper_bound);
        $this->payment_time = str_replace(".0", "", $payment_time);
        $this->boss = $boss;
        $this->allow_custom = $allow_custom;
        $this->minimum = $minimum;
        $this->pos_id = $pos_id;
    }

    public function get_json()
    {
        $json =
            '{"id":"' . json_output::filter($this->id) .
            '","name":"' . json_output::filter($this->name) .
            '","lower_bound":"' . json_output::filter($this->lower_bound) .
            '","prepare_time":"' . json_output::filter($this->prepare_time) .
            '","payment_time":"' . json_output::filter($this->payment_time) .
            '","upper_bound":"' . json_output::filter($this->upper_bound) .
            '","avail_lower_bound":"' . json_output::filter($this->avail_lower_bound) .
            '","avail_upper_bound":"' . json_output::filter($this->avail_upper_bound) .
            '","minimum":"' . json_output::filter($this->minimum) .
            '","boss_id":"' . json_output::filter($this->boss->id) .
            '","boss":' . $this->boss->get_json() .
            ',"daily_produce":"' . json_output::filter($this->limit) .
            '","remaining":"' . json_output::filter($this->get_remaining()) .
            '","allow_custom":"' . ($this->allow_custom ? "true" : "false") . '"}';
        return $json;
    }

    public function __clone()
    {
        $this->id = $this->id;
        $this->name = $this->name;
        $this->lower_bound = $this->lower_bound;
        $this->prepare_time = $this->prepare_time;
        $this->upper_bound = $this->upper_bound;
        $this->avail_upper_bound = $this->avail_upper_bound;
        $this->payment_time = $this->payment_time;
        $this->boss = $this->boss;
        $this->allow_custom = $this->allow_custom;
        $this->minimum = $this->minimum;
        $this->pos_id = $this->pos_id;
        $this->clone_limitable();
    }
}
