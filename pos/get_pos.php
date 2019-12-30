<?php
namespace pos;

function get_pos()
{;
    $self = unserialize($_SESSION["me"]);
    $bank = $self->bank_id;
    $ip = config()["bank"]["ip"];
    $port = config()["bank"]["port"];
    
    $fp = fsockopen($ip, $port ,$errno ,$errstr ,3);
    if(!$fp)
    {
        $rnd = rand(0 ,1);
        if($rnd == 0) {
            announce("先準備一缸酒，再把系統泡進去，這種東西，輕者當日，重者七日就會好，急不得的。" ,$self);
        } else if($rnd == 1) {
            announce("系統掛了，幹。" ,$self);
        }
        throw new \Exception("POS is dead");
    }

    $operation = [
        "operation" => "read",
        "uid" => $bank
    ];
    stream_set_timeout($fp, 3);
    fwrite($fp, json_encode($operation) . "\n");
    if(!$fp) throw new \Exception("Fetch data timeout");

    $data = "";
    while (!feof($fp)) {
        $data .= fgets($fp, 128);
    }
    fclose($fp); 
    $data = json_decode($data ,true);
    $self->pos_init($data["money"] ,$data["cardno"]);

    return $self;
}

?>
