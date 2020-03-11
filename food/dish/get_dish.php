<?php
namespace food;

function get_dish($did = null)
{
    $mysqli = $_SESSION['sql_server'];
    $self = unserialize($_SESSION["me"]);

    $sql = "SELECT D.id ,D.dish_name ,D.charge ,D.is_idle ,DP.id ,D.is_vegetarian ,D.daily_limit
        FROM dish AS D ,department AS DP ,factory as F ,users AS U
        WHERE D.department_id = DP.id AND DP.factory = F.id AND F.boss_id = U.id 
		AND D.id = IFNULL(? ,D.id) AND U.organization_id = ?;";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('ii' ,$did ,$self->org->id);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($did ,$dname ,$dcharge ,$idle ,$dp_id ,$vege ,$limit);
    
    $department = unserialize($_SESSION['department']);
    $result = [];
    while($statement->fetch())
    {
        $result[$did] = new dish($did ,$dname ,$dcharge ,$idle ,$department[$dp_id] ,new vege($vege) ,$limit);
    }
    
    return $result;
}



?>