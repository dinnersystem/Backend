<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require("../backend_proc/backend_main.php");

final class bulk_get_pos extends TestCase
{
    public function get_pos(): void
    {
        $user_1 = new user(1, "", new user_class(1, 1, 1, 1), "12", new org(1, "q"));
        $user_1->bank_id = "131313";

        $pressure = [];
        for($i = 0;$i < 1000;$i++) array_push($pressure, $user_1);
        $data = bulk_get_pos($pressure);
    }
}

