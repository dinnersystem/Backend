<?php
namespace order\money_info;

use \other\check_valid;

function set_payment($req_id ,$password ,$ord_id ,$target)
{
    $ord_id = check_valid::white_list($ord_id ,check_valid::$only_number);
    $result = \order\select_order\select_order(['oid' => $ord_id]);
    $row = reset($result);

    if($row === null) 
        throw new \Exception("Can't find order.");
    payment_auth($row ,$target ,$password ,$req_id);
    
    $mysqli = $_SESSION['sql_server'];
    $mysqli->begin_transaction();
    try
    {
        $sql = "CALL payment(? ,?)";
        $statement = $mysqli->prepare($sql);
        $statement->bind_param('ii' ,$ord_id ,$target);
        $statement->execute(); //to ensure we locked the row.
        $statement->store_result();
        $statement->bind_result($result);
        
        while($statement->fetch()) 
            throw new \Exception($result);
        
        /* The part is extremely slow. Fuck you ,ventem */
        $money = intval(\pos\get_pos()->money);
        if($money < $row->money->charge)
            throw new \Exception("Not enough money.");
        \pos\debit($row ,$hash);

        $mysqli->commit();
    } catch (\Exception $e) {
        $mysqli->rollback();
        throw $e;
    }

    return $row;
}

?>
