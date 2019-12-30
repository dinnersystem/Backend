<?php
namespace order\select_order;

function get_factory_id($uid)
{
    $factory = unserialize($_SESSION['factory']);
    foreach($factory as $f)
        if($f->boss_id == $uid) return strval($f->id);
    throw new \Exception("You do not own any factory");
}

?>