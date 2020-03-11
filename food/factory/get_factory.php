<?php
namespace food;

function get_factory()
{
    $mysqli = $_SESSION['sql_server'];
    $self = unserialize($_SESSION["me"]);

    $sql = "SELECT F.id ,F.name ,
        F.lower_bound ,F.upper_bound ,F.pre_time ,F.payment_time ,F.avail_lower_bound ,F.avail_upper_bound ,
        F.boss_id ,F.allow_custom ,F.minimum ,F.pos_id
        FROM factory AS F ,users AS U
        WHERE F.boss_id = U.id AND U.organization_id = ?;";
    
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('i', $self->org->id);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($fid ,$fname ,
        $lower_bound ,$upper_bound ,$pre_time ,$payment_time ,$avail_lower_bound ,$avail_upper_bound ,
        $boss_id ,$allow_custom ,$minimum ,$pos_id
    );
    
    $user = unserialize($_SESSION["user"]);
    $result = [];
    while($statement->fetch()) {
        $result[$fid] = new factory($fid ,$fname ,
            $lower_bound ,$pre_time ,$upper_bound ,$avail_lower_bound ,$avail_upper_bound ,$payment_time ,
            $user[$boss_id] ,$allow_custom ,$minimum , $pos_id
        );
    }
    
    return $result;
}

?>