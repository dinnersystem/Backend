<?php
namespace order\money_info;

function raw_auth($row ,$password)
{
    $self = unserialize($_SESSION["me"]);
    return $password === $self->PIN;
}

?>