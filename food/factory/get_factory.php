<?php
namespace food;

function get_factory()
{
    $mysqli = $_SESSION['sql_server'];
    $sql = "SELECT F.id ,F.name ,
        F.lower_bound ,F.upper_bound ,F.pre_time ,F.payment_time ,
        F.boss_id ,F.allow_custom ,F.minimum ,F.pos_id
        FROM dinnersys.factory AS F;";
    
    $statement = $mysqli->prepare($sql);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($fid ,$fname ,
        $lower_bound ,$upper_bound ,$pre_time ,$payment_time ,
        $boss_id ,$allow_custom ,$minimum ,$pos_id
    );
    
    $result = [];
    while($statement->fetch())
    {
        $result[$fid] = new factory($fid ,$fname ,
            $lower_bound ,$pre_time ,$upper_bound ,$payment_time,
            $boss_id ,$allow_custom ,$minimum , $pos_id
        );
    }
    
    return $result;
}

?>