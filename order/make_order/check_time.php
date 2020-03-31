<?php
namespace order\make_order;

function check_time($dishes ,$esti_recv) {
    $recv = \other\date_api::is_valid_time($esti_recv);
    if(\config()["enviroment"]["check_order_time"] === false) return true;

    $date = $recv->format("Y-m-d"); 
    if($date !== date("Y-m-d")) throw new \Exception("Not allow order at tomorrow");

    
    foreach($dishes as $dish) {
        $factory = $dish->department->factory;
        $prepare = $dish->department->factory->prepare_time;
        
        # esti_recv >= now + prepare
        # echo ($recv->getTimestamp() + 8 * 60 * 60) . " " . (strtotime("1970-01-01 $prepare UTC") + strtotime("Now") + 8 * 60 * 60) . "<br>";
        if(!($recv->getTimestamp() + 8 * 60 * 60 >= (strtotime("1970-01-01 $prepare UTC") + strtotime("Now") + 8 * 60 * 60)))
            throw new \Exception('Impossible to make the order.');

        # $lower_bound < $esti_recv < $upper_bound
        $lower_bound = $date . ' ' . substr($factory->lower_bound , 0, 8);
        $upper_bound = $date . ' ' . substr($factory->upper_bound , 0 ,8);
        $recv_parsed = $recv->format("Y-m-d H:i:s");
        # echo $lower_bound . " " . $esti_recv . " " . $upper_bound;
        if(!\other\date_api::is_between($lower_bound ,$recv_parsed ,$upper_bound)) throw new \Exception("Off hours.");
        
        # $avail_lower_bound < $now < $avail_upper_bound
        $now = date("Y-m-d");
        $avail_lower_bound = $now . ' ' . substr($factory->avail_lower_bound , 0, 8);
        $avail_upper_bound = $now . ' ' . substr($factory->avail_upper_bound , 0 ,8);
        $now_parsed = date("Y-m-d H:i:s");
        if(!\other\date_api::is_between($avail_lower_bound ,$now_parsed ,$avail_upper_bound)) throw new \Exception("Not allow online purchase yet.");
    }
    return true;
}

?>