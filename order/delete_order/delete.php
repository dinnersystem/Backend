<?php
namespace order;
use \other\check_valid;

function delete_order($order_id ,$type)
{
    $order_id = check_valid::white_list($order_id ,check_valid::$only_number);
    $data = \order\select_order\select_order(['oid' => $order_id]);
    $row = reset($data);
    
    if($row == false)
        throw new \Exception("Unable to find the row");

    delete_auth($row ,$type);

    $sql_command = "CALL delete_order(?, ?)";
    
    $mysqli = $_SESSION['sql_server'];
    $statement = $mysqli->prepare($sql_command);
    
    $supreme = ($type == 'none');
    $statement->bind_param('ii' ,$order_id ,$supreme);
    $statement->execute();

    return $row;
}

?>