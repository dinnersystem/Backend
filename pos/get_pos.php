<?php
namespace pos;

function get_pos() {
    $self = unserialize($_SESSION["me"]);

    $conf = config()["enviroment"]["fake_payment"];
    if($conf["enable"] === true) {
        $self->pos_init($conf["fake_money"] ,$conf["fake_cardno"]);
        return $self;
    }

    $ip = config()["payment_server"]["ip"];
    $port = config()["payment_server"]["port"];
    
    $fp = fsockopen($ip, $port ,$errno ,$errstr ,3);
    if(!$fp) throw new \Exception("Cannot connect to payment server");

    $operation = [
        "operation" => "read",
        "org_id" => strval($self->org->id),
        "payload" => $self
    ];
    stream_set_timeout($fp, 3);
    fwrite($fp, json_encode($operation) . "\n");
    if(!$fp) throw new \Exception("Fetch data timeout");

    $data = "";
    while (!feof($fp)) $data .= fgets($fp, 128);
    fclose($fp); 
    $json = json_decode($data ,true);
    if($json == null) {
        announce("查詢 - 回傳空資料", unserialize($_SESSION["me"]));
        throw new \Exception("Invalid json from payment_server " . $data);
    }
    
    if (array_key_exists("error", $json)) {
        announce("查詢 - 發生錯誤", unserialize($_SESSION["me"]));
        throw new \Exception(strval($json["error"]));
    }
    $self->pos_init($json["money"] ,$json["cardno"]);

    return $self;
}

?>
