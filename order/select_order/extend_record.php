<?php
namespace order\select_order;

function extend_payment($rows)
{
    $oids = [];
    foreach($rows as $row)
        $oids[] = intval($row->id);
    
    $data = \order\money_info\get_payments($oids);

    foreach($oids as $oid)
    {
        $payments = $data[$oid];
        $rows[$oid]->money->init_payment($payments);
    }
    return $rows;
}

function extend_buffet($rows ,$history)
{
    $oids = [];
    foreach($rows as $row)
        $oids[] = intval($row->id);
    
    $data = \food\get_buffets($oids);
    
    foreach($oids as $oid)
        $rows[$oid]->init_buffet($data[$oid] ,$history);
    return $rows;
}

function extend_cargo($rows)
{

}

?>