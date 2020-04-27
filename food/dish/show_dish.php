<?php
namespace food;

function show_dish($sortby)
{
    $flimit = fetch_factory();
    $dlimit = fetch_dish();

    $me = unserialize($_SESSION['me']);
    $dish = get_dish();
    $department = unserialize($_SESSION["department"]);
    $factory = get_factory(true);
    
    foreach($dlimit as $key => $row) $dish[$key]->init_limit($row["last_update"] ,$row["sum"] ,$row["limit"]);
    foreach($flimit as $key => $row) $factory[$key]->init_limit($row["last_update"] ,$row["sum"] ,$row["limit"]);

    foreach($department as $dp) $dp->factory = $factory[$dp->factory->id];
    foreach($dish as $d) $d->department = $department[$d->department->id];

    if($sortby != "dish_id")
        usort($dish, function ($a, $b) {
            if($a->best_seller && !$b->best_seller) return false;
            else if(!$a->best_seller && $b->best_seller) return true;
            else if($a->sum == $b->sum) return $a->id > $b->id;
            else return $a->sum < $b->sum;
        });
    return $dish;
}
