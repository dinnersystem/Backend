<?php
namespace order\make_order;

function check_time($dishes ,$esti_recv)
{
    $recv = \other\date_api::is_valid_time($esti_recv);
    $date = $recv->format("Y-m-d");
    if($date !== date("Y-m-d"))
        throw new \Exception("Not allow order at tomorrow");

    foreach($dishes as $dish)
    {
        $lower_bound = $date . ' ' . substr($dish->department->factory->lower_bound , 0, 8);
        $upper_bound = $date . ' ' . substr($dish->department->factory->upper_bound , 0 ,8);
        $prepare = $dish->department->factory->prepare_time;
        
        # esti_recv >= now + prepare
        # echo ($recv->getTimestamp() + 8 * 60 * 60) . " " . (strtotime("1970-01-01 $prepare UTC") + strtotime("Now") + 8 * 60 * 60) . "<br>";
        if(!($recv->getTimestamp() + 8 * 60 * 60 >= 
            (strtotime("1970-01-01 $prepare UTC") + strtotime("Now") + 8 * 60 * 60)))
            throw new \Exception('Impossible to make the order.');

        # $lower_bound < $esti_recv < $upper_bound
        # echo $lower_bound . " " . $esti_recv . " " . $upper_bound;
        $recv_parsed = $recv->format("Y-m-d H:i:s");
        if(!\other\date_api::is_between($lower_bound ,$recv_parsed ,$upper_bound))
            throw new \Exception("Off hours.");
    }
    return true;
}

?>