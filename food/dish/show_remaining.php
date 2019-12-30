<?php
namespace food;

function show_remaining($did)
{
    $did = \other\check_valid::white_list($did ,\other\check_valid::$only_number); 

    $dish = unserialize($_SESSION["dish"]);
    if($dish[$did]->daily_produce == -1) 
        return $dish[$did];

    $mysqli = $_SESSION['sql_server'];
    $today = date("Y-m-d");
    $lower_bound = $today . ' 00:00:00';
    $upper_bound = $today . ' 23:59:59';
    $sql = "SELECT COUNT(O.id) FROM orders AS O ,buffet AS B ,logistics_info AS LO
        WHERE B.dish = ? AND B.order = O.id AND O.disabled = FALSE
        AND O.logistics_id = LO.id AND LO.esti_recv_datetime BETWEEN ? AND ?
        LOCK IN SHARE MODE;";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('iss' ,$did ,$lower_bound ,$upper_bound);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($sum);
    
    if($statement->fetch())
    {
        $dish[$did]->sold_out = $sum;
        $dish[$did]->remaining = $dish[$did]->daily_produce - $sum;
    }

    return $dish[$did];
}



?>