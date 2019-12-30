<?php
namespace order\make_order;

function get_user_id($seat_id ,$type)
{
    $cno = null;
    $self = unserialize($_SESSION['me']);
    switch($type) {
        case "self":
            return $self->id;
            break;
        case "everyone":
            break;
    }

    $sql_command = "SELECT U.id FROM users AS U ,user_information AS UI
        WHERE UI.seat_id = ? AND UI.id = U.info_id;";
    
    $mysqli = $_SESSION['sql_server'];
    $statement = $mysqli->prepare($sql_command);
    $statement->bind_param('s' ,$seat_id);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($result);
    
    if($statement->fetch()) return $result;
    else throw new \Exception("Invalid seat_id.");
}


?>