<?php
namespace punish;

function attempt($uid ,$req_id ,$type)
{
    $punish = date("Y-m-d H:i:s" ,\config()[$type]["punish"] + \time());
    $sql = "INSERT INTO `dinnersys`.`attempt` (`until`,`type`,`log`,`uid`) VALUES (? ,? ,? ,?)";
    $mysqli = $_SESSION['sql_server'];
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('ssii',$punish ,$type ,$req_id ,$uid);
    $statement->execute();
    # var_dump(get_defined_vars());
}

?>