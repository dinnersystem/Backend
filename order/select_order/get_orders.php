<?php
namespace order\select_order;

function get_orders($statement)
{
    $statement->bind_result($id, $esti_recv, $user_id, $money_id, $money_sum);
    
    $user_table = unserialize($_SESSION['user']);
    $result = [];
    while ($statement->fetch()) {
        $result[$id] = new \order\order(
            $id,
            $user_table[$user_id],
            $esti_recv,
            new \order\money_info\money_info($money_id, $money_sum)
        );
    }
    return $result;
}
