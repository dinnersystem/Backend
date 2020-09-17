<?php
use Spatie\Async\Pool;

namespace pos;

function bulk_get_pos($users) {
    $ans = []; 
    $pool = Pool::create();
    
    $available_async = 100;
    foreach ($users as $user) {
        $avaialble_async -= 1;

        $pool->add(function () use ($user) {
            $conf = config()["enviroment"]["fake_payment"];
            if($conf["enable"] === true) {
                $user->pos_init($conf["fake_money"] ,$conf["fake_cardno"]);
                return $user;
            }
        
            $ip = config()["payment_server"]["ip"];
            $port = config()["payment_server"]["port"];
        
            $fp = fsockopen($ip, $port ,$errno ,$errstr ,3);
            if (!$fp) {
                announce("查詢 - Unable to connect to payment server", $user);
                throw new \Exception("Cannot connect to payment server");
            }
         
            $operation = [
                "operation" => "read",
                "org_id" => strval($user->org->id),
                "payload" => $user
            ];
            fwrite($fp, json_encode($operation) . "\n");
            if(!$fp) throw new \Exception("Fetch data timeout");
            
            $data = "";
            while (!feof($fp)) $data .= fgets($fp, 128);
            fclose($fp);
            $json = json_decode($data ,true);
            if($json == null) {
                announce("查詢 - 回傳空資料", $user);
                throw new \Exception("Invalid json from payment_server " . $data);
            }
            
            if (array_key_exists("error", $json)) {
                announce("查詢 - 發生錯誤", $user);
                throw new \Exception(strval($json["error"]));
            }
            $self->pos_init($json["money"] ,$json["cardno"]);
            return $user;
        })->then(function ($output) {
            $available_async += 1;
            array_push($ans, $output);
        })->catch(function (Throwable $exception) {
            throw $exception;
        });
        if($available_async <= 0) $pool->wait();
    }
    $pool->wait();

    return $ans;
}

?>
