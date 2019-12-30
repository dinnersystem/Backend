<?php
namespace punish;

function check($uid ,$type)
{
    $result = 0;
    $sql = 'SELECT count(id) FROM attempt WHERE (uid = ?) AND (until > CURRENT_TIMESTAMP) AND type = ?';
    $mysqli = $_SESSION['sql_server'];
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('is',$uid ,$type);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($result);
    $statement->fetch();

    $tolerance = config()[$type]["tolerance"];
    if($result > $tolerance)
        throw new \Exception("Punish not over");
}


?>