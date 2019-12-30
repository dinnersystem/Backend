<?php
namespace other;

function error_report($data)
{
    $uid = unserialize($_SESSION['me'])->id;
    $mysqli = $_SESSION['sql_server'];
    $sql = "INSERT INTO `dinnersys`.`error_report` (`uid`, `msg`)
        VALUES (? ,?);";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('is' ,$uid ,$data);
    $statement->execute();
    return "Recorded report";
}

?>