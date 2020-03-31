<?php
namespace food;

function get_department()
{
    $mysqli = $_SESSION['sql_server'];
    $self = unserialize($_SESSION["me"]);

    $sql = "SELECT D.id ,D.name ,D.factory 
        FROM department AS D, factory AS F ,users AS U
        WHERE U.organization_id = ? AND F.boss_id = U.id AND F.id = D.factory;";
    
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('i', $self->org->id);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($did, $dname, $fid);
    
    $facto = unserialize($_SESSION['factory']);
    $result = [];
    while ($statement->fetch()) {
        $result[$did] = new department($did, $dname, $facto[$fid]);
    }
    
    return $result;
}
