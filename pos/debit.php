<?php
namespace pos;

function debit($row)
{
    die(json_encode($row));
    if (config()["enviroment"]["fake_payment"]["enable"] === true) return true;

    $self = unserialize($_SESSION["me"]);
    $ip = config()["payment_server"]["ip"];
    $port = config()["payment_server"]["port"];
    $row->user = $self;

    $fp = fsockopen($ip, $port, $errno, $errstr, 3);
    if(!$fp) throw new \Exception("Cannot connect to payment server");

    
    $operation = [
        "operation" => "write" ,
        "org_id" => strval($self->org->id),
        "payload" => [
            "b" => $self->bank_id,
            "p" => $row->buffet[0]->dish->department->factory->pos_id,
            "d" => $row->money->charge
        ]
    ];
    stream_set_timeout($fp, 3);
    fwrite($fp, json_encode($operation, JSON_INVALID_UTF8_IGNORE) . "\n");
    if(!$fp) throw new \Exception("Fetch data timeout");

    $data = "";
    while (!feof($fp)) $data .= fgets($fp, 128);
    fclose($fp);
    $json = json_decode($data ,true);

    if ($data == null || array_key_exists("error", $json)) {
        announce("#### 有人繳款失敗，請注意 ####", $row->user);
        throw new \Exception(strval($json["error"]));
    } else return true;
}
