<?php
namespace food;

function get_department()
{
    $mysqli = $_SESSION['sql_server'];
    $sql = "SELECT D.id ,D.name ,D.factory
            FROM department AS D;";
    
    $statement = $mysqli->prepare($sql);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($did ,$dname ,$fid);
    
    $facto = unserialize($_SESSION['factory']);
    $result = [];
    while($statement->fetch())
    {
        $result[$did] = new department($did ,$dname ,$facto[$fid]);
    }
    
    return $result;
}

?>