<?php
namespace other;

function init_server()
{
    $host = config()["database"]["ip"];
    $account = config()["database"]["account"];
    $password = config()["database"]["password"];
    $database = config()["database"]["name"];
    if(!array_key_exists('sql_server' ,$_SESSION) || !$_SESSION['sql_server']->ping()) {
        $server_connection = new \mysqli($host, $account, $password, $database);
        \mysqli_set_charset($server_connection ,"utf8");
        $_SESSION['sql_server'] = $server_connection;
    }
} 

?>