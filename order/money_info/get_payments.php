<?php
namespace order\money_info;

function get_payments($oids)
{
    if(count($oids) == 0) return [];

    $mysqli = $_SESSION['sql_server'];
    $sql = "SELECT
        O.id,
        P.id, P.paid,
        P.able_datetime, P.paid_datetime, P.freeze_datetime,
        P.tag, P.reversable

        FROM orders AS O
        INNER JOIN money_info AS M		ON O.money_id = M.id
        INNER JOIN payment AS P         ON P.money_info = M.id
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
        $pid ,$paid ,
        $able_dt ,$paid_dt ,$freeze_dt ,
        $tag ,$reversable
    );

    $result = [];
    while($statement->fetch())
    {
        $result[$oid][$tag] = new payment($pid ,($paid == 1),
            $able_dt ,$paid_dt ,$freeze_dt,
            $tag ,$reversable);
    }
    return $result;
}
?>