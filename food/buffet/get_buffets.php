<?php
namespace food;

function get_buffets($oids)
{
    if(count($oids) == 0) return [];

    $mysqli = $_SESSION['sql_server'];
    $sql = "SELECT
        O.id,
        BF.id ,BF.dish,
        (SELECT DH.dish_name FROM dish_history AS DH WHERE LO.esti_recv_datetime BETWEEN DH.born_at AND DH.die_at AND DH.dish_id = BF.dish LIMIT 1),
        (SELECT DH.charge FROM dish_history AS DH WHERE LO.esti_recv_datetime BETWEEN DH.born_at AND DH.die_at AND DH.dish_id = BF.dish LIMIT 1),
        (SELECT DH.daily_limit FROM dish_history AS DH WHERE LO.esti_recv_datetime BETWEEN DH.born_at AND DH.die_at AND DH.dish_id = BF.dish LIMIT 1)

        FROM orders AS O
        INNER JOIN buffet AS BF ON BF.order = O.id
        INNER JOIN logistics_info AS LO ON O.logistics_id = LO.id
    ";

    $extend_sql = " WHERE O.id IN(";
    $types = "";
    $value = array();
    foreach($oids as $id)
    {
        $value[] = $id;
        $types .= "i";
        $extend_sql .= "? ,";
    }
    $extend_sql = substr($extend_sql ,0 ,-1) . ")";
    $sql .= $extend_sql;
    
    /*var_dump($value);
    die($sql);*/

    $statement = $mysqli->prepare($sql);
    $statement->bind_param($types , ...$value);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($oid ,
        $bid ,$did ,
        $dname ,$dcharge ,$daily_limit
    );

    $result = [];
    $dish_table = unserialize($_SESSION["dish"]);
    while($statement->fetch())
    {
        $dish = clone $dish_table[$did];
        $dish->name = $dname;
        $dish->charge = $dcharge;
        $dish->daily_produce = $daily_limit;
        $result[$oid][] = new buffet($bid ,$dish ,$oid);
    }
    return $result;
}
?>