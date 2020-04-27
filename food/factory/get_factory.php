<?php
namespace food;

function get_factory($all)
{
    $mysqli = $_SESSION['sql_server'];
    $self = unserialize($_SESSION["me"]);

    $sql = "SELECT F.id ,F.name ,
        F.lower_bound ,F.upper_bound ,F.pre_time ,F.payment_time ,F.avail_lower_bound ,F.avail_upper_bound ,
        F.boss_id ,F.allow_custom ,F.minimum ,F.pos_id ,F.external,
        NOT (NOT F.activated AND O.max_external = O.external_sum) OR NOT F.external
        FROM factory AS F, users AS U, organization AS O
        WHERE F.boss_id = U.id AND U.organization_id = O.id AND O.id = ?;";
    
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('i', $self->org->id);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result(
        $fid,
        $fname,
        $lower_bound,
        $upper_bound,
        $pre_time,
        $payment_time,
        $avail_lower_bound,
        $avail_upper_bound,
        $boss_id,
        $allow_custom,
        $minimum,
        $pos_id,
        $external,
        $orderable
    );
    
    $user = unserialize($_SESSION["user"]);
    $result = [];
    while ($statement->fetch()) {
        if($orderable || $all)
            $result[$fid] = new factory(
                $fid,
                $fname,
                $lower_bound,
                $pre_time,
                $upper_bound,
                $avail_lower_bound,
                $avail_upper_bound,
                $payment_time,
                $user[$boss_id],
                $allow_custom,
                $minimum,
                $pos_id,
                $external,
                $orderable
            );
    }
    
    return $result;
}
