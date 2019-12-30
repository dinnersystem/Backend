<?php
namespace user\login;

function raw_auth($login_id ,$password)
{
    $data = fetch($login_id);
    if($data == NULL) return "No account";
    return $data["password"] == $password;
}

?>