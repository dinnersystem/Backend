<?php
namespace user;

function logout()
{
    $cmd = "UPDATE `dinnersys`.`users`
        SET `device_id` = NULL
        WHERE `id` = ?;";
    $mysqli = $_SESSION['sql_server'];
    $statement = $mysqli->prepare($cmd);
    $statement->bind_param('i' ,unserialize($_SESSION['me'])->id);
    $statement->execute();
    
    $_SESSION['me'] = null;
}
    
?>