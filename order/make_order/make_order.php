<?php
namespace order\make_order;

use \other\check_valid;
use \other\date_api;
use function \food\get_dish_string;

function make_order($target_id ,$dishes ,$esti_recv ,$type)
{
    $dishes = check_dish($dishes);
    check_time($dishes ,$esti_recv);  
    $uid = get_user_id($target_id ,$type);
    $self_id = unserialize($_SESSION['me'])->id;

    /*-------------------------------------------*/
    $dstring = get_dish_string($dishes); 
    # This might be vulnerable if dish->id could be any string.
    /*-------------------------------------------*/

    $sql_command = "CALL make_order(? ,? ,? ,?);";
    $mysqli = $_SESSION['sql_server'];
    $statement = $mysqli->prepare($sql_command);
    $statement->bind_param('iiss' , $uid ,$self_id ,$dstring, $esti_recv);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($result);
    
    $oid = null;
    if($statement->fetch())
    {
        if(is_int($result)) $oid = $result;
        else throw new \Exception($result);
    }
    else
        throw new \Exception("Unable to fetch data from server.");
    
    while($mysqli->more_results()) $mysqli->next_result();    
    $row = \order\select_order\select_order(['oid' => strval($oid)]); 
    return $row;
}

?>