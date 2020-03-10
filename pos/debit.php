<?php
namespace pos;

function debit($row)
{
    if (config()["enviroment"]["fake_payment"]["enable"] === true) {
        return true;
    }

    $self = unserialize($_SESSION["me"]);
    $bank = $self->bank_id;
    $ip = config()["payment_server"]["ip"];
    $port = config()["payment_server"]["port"];

    $auth = json_encode([
        "password" => $password,
        "timestamp" => strval(time())
    ]);
    $auth = hash("SHA512", $auth);
    
    $fp = fsockopen($ip, $port, $errno, $errstr, 3);
    if (!$fp) {
        throw new \Exception("POS is dead");
    }

    $msg = [
        "operation" => "write" ,
        "uid" => $bank,
        "charge" => $row->money->charge,
        "fid" => reset($row->buffet)->dish->department->factory->pos_id,
        "auth" => $auth
    ];
    $msg = json_encode($msg);
    fwrite($fp, $msg . "\n");
    stream_set_timeout($fp);

    $data = "";
    while (!feof($fp)) {
        $data .= fgets($fp, 128);
    }
    fclose($fp);

    if ($data == "success") {
        return true;
    } else {
        announce("#### 有人繳款失敗，請注意 ####", $row->user);
        throw new \Exception("POS is dead");
    }
}
