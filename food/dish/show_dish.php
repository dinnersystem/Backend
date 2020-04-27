<?php
namespace food;

function show_dish($sortby)
{
    $flimit = fetch_factory();
    $dlimit = fetch_dish();

    $me = unserialize($_SESSION['me']);
    $dish = get_dish();
    $department = get_department();
    $factory = get_factory(false);
    
    foreach ($dlimit as $key => $row) {
        $dish[$key]->init_limit($row["last_update"], $row["sum"], $row["limit"]);
    }
    foreach ($flimit as $key => $row) {
        if (array_key_exists($key, $factory)) {
            $factory[$key]->init_limit($row["last_update"], $row["sum"], $row["limit"]);
        }
    }

    foreach ($department as $dp) {
        if (array_key_exists($dp->factory->id, $factory)) {
            $dp->factory = $factory[$dp->factory->id];
        } else {
            $dp->factory = null;
        }
    }

    $ans = [];
    foreach ($dish as $d) {
        if ($department[$d->department->id]->factory != null) {
            $d->department = $department[$d->department->id];
            $ans[] = $d;
        }
    }

    if ($sortby != "dish_id") {
        usort($ans, function ($a, $b) {
            if ($a->best_seller && !$b->best_seller) {
                return false;
            } elseif (!$a->best_seller && $b->best_seller) {
                return true;
            } elseif ($a->sum == $b->sum) {
                return $a->id > $b->id;
            } else {
                return $a->sum < $b->sum;
            }
        });
    }
    return $ans;
}
