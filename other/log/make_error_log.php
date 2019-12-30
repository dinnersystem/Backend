<?php
namespace other\log;

function make_error_log($req_id ,$output)
{
    $output = substr($output ,0 ,4000);
    $mysqli = $_SESSION['sql_server'];
    $sql = "INSERT INTO `dinnersys`.`error_log`(`log`,`output`) VALUES(? ,?);";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('is' ,$req_id ,$output);
    $statement->execute();
}

?>