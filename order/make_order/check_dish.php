<?php
namespace order\make_order;
use \other\check_valid;

function check_dish($dishes)
{
    if(!is_array($dishes))
        throw new \Exception("Must input as an array.");
    
    if(count($dishes) == 0) 
        throw new \Exception("No dish data.");
    
    $ret = [];
    $count = [];
    $dish_table = unserialize($_SESSION['dish']);
    $fid = null;
    foreach($dishes as $dish_id)
    {
        $dish_id = check_valid::white_list($dish_id ,check_valid::$only_number);
        $dish = $dish_table[$dish_id];
        if($dish == null) throw new \Exception("Invalid dish id.");
        if($dish->is_idle) throw new \Exception("The dish is in idle.");

        if($fid == null) 
            $fid = $dish->department->factory->id;
        else
            if($fid != $dish->department->factory->id)
                throw new \Exception("Not allow multiple factory.");

        if(count($dishes) > 1 && !$dish->department->factory->allow_custom)
            throw new \Exception("Not allow custom dish.");
        
        if(!array_key_exists($dish_id ,$count)) $count[$dish_id] = 0;
        $count[$dish_id] += 1;

        $ret[] = $dish;
    }

    foreach($count as $item)
        if($item > 5)
            throw new \Exception("Too much ingredients.");

    $sum = 0;
    foreach($dishes as $did)
        $sum += $dish_table[$did]->charge;
    $minimum = $dish_table[reset($dishes)]->department->factory->minimum;
    if($sum < $minimum && $minimum > 0)
        throw new \Exception("Must be higher than mimimum.");
    return $ret;
}

?>