<?php
namespace food;

function get_dish_string($dishes)
{
    $sql = "(";
    foreach($dishes as $dish)
        $sql .= $dish->id . ',';
    $sql = substr($sql ,0 ,-1);
    return $sql . ")";
}

function allow_buffet($dish)
{
    $dish_table = unserialize($_SESSION["dish"]);
    foreach($dish as $id)
    {
        $allow = $dish_table[$id]->department->factory->allow_buffet;
        if(!$allow && count($dish) != 1) 
            throw new Exception("Not allow multiple order.");
    }
}

?>