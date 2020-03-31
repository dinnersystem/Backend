<?php
namespace user;

function get_organization()
{
    $mysqli = $_SESSION['sql_server'];
    $sql = "SELECT O.id ,O.name FROM organization AS O;";
    
    $statement = $mysqli->prepare($sql);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($oid ,$oname);
    
    $result = [];
    while($statement->fetch()) $result[$oid] = new organization($oid ,$oname);
    return $result;
}
?>