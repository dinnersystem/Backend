<?php
namespace user;

class previleges
{
    public static $prevs = [
        'guest' => 1,
        'normal' => 2,
        'dinnerman' => 4,
        'factory' => 8,
        'cafeteria' => 16,
        'admin' => 32
    ];

    public static function get_prevs($prev_sum)
    {
        $prevs = array_flip(self::$prevs);
        $result = [];
        $count = 32;
        while($count != 0)
        {
            if($prev_sum >= $count)
            {
                $prev_sum -= $count;
                $result[] = $prevs[$count];
            }
            $count = floor($count / 2);
        }
        return $result;
    }
}


?>