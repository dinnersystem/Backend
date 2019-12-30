<?php
namespace user;

function get_class()
{
    $mysqli = $_SESSION['sql_server'];
    $sql = "SELECT C.id ,C.year ,C.grade ,C.class_no
            FROM dinnersys.class AS C;";
    
    $statement = $mysqli->prepare($sql);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($cid ,$year ,$grade ,$cno);
    
    $result = [];
    while($statement->fetch()) 
    {
        $result[$cid] = new user_class($cid ,$year ,$grade ,$cno);
    }
    return $result;
}
?>