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
    $data = json_decode($data ,true);
    
    if(array_key_exists("error" ,$data)) throw new \Exception(strval($data["error"]));
    $self->pos_init($data["money"] ,$data["cardno"]);

    return $self;
}

?>
