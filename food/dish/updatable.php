<?php
namespace food;

function updatable($fid)
{
    $user = unserialize($_SESSION['me']);
    $factory = unserialize($_SESSION["factory"])[$fid];
        
    if($factory->boss_id == $user->id)
        return true;
    
    foreach($user->prev as $p)
    {
        if($p == "admin")
            return true;
        if($p == "cafeteria")
            return true;
    }
        
        
    return false;
}

?>