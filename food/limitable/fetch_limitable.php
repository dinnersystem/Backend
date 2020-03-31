<?php
namespace food;

function fetch_factory()
{
    $mysqli = $_SESSION['sql_server'];
    $self = unserialize($_SESSION["me"]);
    $sql = "SELECT F.id ,F.daily_limit ,F.sum ,F.last_update 
        FROM factory AS F, users AS U 
        WHERE U.id = F.boss_id AND U.organization_id = ?;";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('i', $self->org->id);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($id, $limit, $sum, $update);

    $ret = [];
    while ($statement->fetch()) {
        $ret[$id] = ["limit" => $limit ,"sum" => $sum ,"last_update" => $update];
    }
    return $ret;
}

function fetch_dish($did = null)
{
    $mysqli = $_SESSION['sql_server'];
    $self = unserialize($_SESSION["me"]);
    $sql = "SELECT D.id ,D.daily_limit ,D.sum ,D.last_update 
        FROM dish AS D ,department AS DP ,factory AS F ,users AS U
        WHERE D.department_id = DP.id AND DP.factory = F.id AND F.boss_id = U.id 
        AND U.organization_id = ? AND IFNULL(? ,D.id) = D.id;";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('ii', $self->org->id, $did);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($id, $limit, $sum, $update);

    $ret = [];
    while ($statement->fetch()) {
        $ret[$id] = ["limit" => $limit ,"sum" => $sum ,"last_update" => $update];
    }
    return $ret;
}
