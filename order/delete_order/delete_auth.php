<?php
namespace order;

function delete_auth($row ,$type) {
    $self = unserialize($_SESSION['me']);
    switch($type) {
        case "self":
            if($row->user->id != $self->id) 
                throw new \Exception("No permission to delete this order.");
            break;
        case 'none':
            break;
    }

    $date = strtotime($row->esti_recv);
    $now = time();
    if(date("Y-m-d" ,$date) !== date("Y-m-d" ,$now))
        throw new \Exception("Only allowed to delete order at today");
    return true;
}

?>