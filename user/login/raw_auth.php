<?php
namespace user\login;

function fetch($login_id, $org_id)
{
    $sql_command = "SELECT id ,password FROM users WHERE login_id = ?;";
    $mysqli = $_SESSION['sql_server'];
    $statement = $mysqli->prepare($sql_command);
    $statement->bind_param('s', $login_id);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($id, $password);
    $statement->fetch();
    return ["id" => $id ,"password" => $password];
}

function raw_auth($login_id, $org_id, $password)
{
    $data = fetch($login_id, $org_id);
    if ($data == null) return "No account";
    return $data["password"] == $password;
}
