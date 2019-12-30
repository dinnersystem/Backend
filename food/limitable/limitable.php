<?php
namespace food;

class limitable {
    public $sum;
    public $limit;
    public $last_update;
    const max = 2147483647;

    function init_limit($last_update ,$sum ,$limit) {
        $this->sum = (date("Y-m-d" ,strtotime($last_update)) === date("Y-m-d") ? $sum : 0);
        $this->limit = $limit;
        $this->last_update = $last_update;
    }

    function get_remaining() {
        if(date("Y-m-d" ,strtotime($this->last_update)) === date("Y-m-d")) {
            if($this->limit == -1) {
                return self::max;
            } else {
                return intval($this->limit) - intval($this->sum);
            }
        } else {
            if($this->limit == -1) {
                return self::max;
            } else {
                return $this->limit;
            }
        }
    }

    function clone_limitable() {
        $this->sum = $this->sum;
        $this->limit = $this->limit;
        $this->last_update = $this->last_update;
    }
}


?>