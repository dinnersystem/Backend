<?php
namespace food;

function fetch_factory() 
{
    $mysqli = $_SESSION['sql_server'];
    $sql = "SELECT F.id ,F.daily_limit ,F.sum ,F.last_update FROM factory AS F;";
    $statement = $mysqli->prepare($sql);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($id ,$limit ,$sum ,$update);

    $ret = [];
    while($statement->fetch()) {
        $ret[$id] = [
            "limit" => $limit ,
            "sum" => $sum ,
            "last_update" => $update
        ];
    }
    return $ret;
}

function fetch_dish()
{
    $mysqli = $_SESSION['sql_server'];
    $sql = "SELECT D.id ,D.daily_limit ,D.sum ,D.last_update FROM `dinnersys`.`dish` AS D;";
    $statement = $mysqli->prepare($sql);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($id ,$limit ,$sum ,$update);

    $ret = [];
    while($statement->fetch()) {
        $ret[$id] = [
            "limit" => $limit ,
            "sum" => $sum ,
            "last_update" => $update
        ];
    }
    return $ret;
}

?>