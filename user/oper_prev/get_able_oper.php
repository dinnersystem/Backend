<?php
namespace user;

function get_able_oper($prev_sum)
{
    $prevs = previleges::get_prevs($prev_sum);
    $result = [];
    foreach($prevs as $prev_name)
    {
        $opers = operation::get_oper($prev_name);
        foreach($opers as $key => $value)
            $result[$key] = $value;
    }
    return $result;
}

?>