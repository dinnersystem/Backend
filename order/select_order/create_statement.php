<?php
namespace order\select_order;

function create_statement($param)
{
    $syntax = [
        ['esti_start'    ,'AND (? < LO.esti_recv_datetime)'                                        ,'s'],
        ['esti_end'      ,'AND (? > LO.esti_recv_datetime)'                                        ,'s'],

        ['factory_id'    ,'AND (? = DP.factory)'                                                 ,'i'],
        ['person'        ,'AND (? = O.user_id)'                                                    ,'i' ,$param['user_id']],
        ['class'         ,'AND ((SELECT U.class_id FROM users AS U WHERE U.id = ?) = U.class_id)'  ,'i' ,$param['user_id']], 
        ['oid'           ,'AND (? = O.id)'                                                         ,'i']
    ];

    $sql = normal_sql();
    $type = "";
    $value = [];

    foreach($syntax as $row) {
        if(!isset($param[$row[0]])) continue;
        
        if(array_key_exists(3 ,$row))
            $value[] = intval($row[3]);
        else
            $value[] = $param[$row[0]];
            

        $sql .= $row[1];
        $type .= $row[2];
    }
    $sql .= " ORDER BY O.id ";

    $mysqli = $_SESSION['sql_server'];
    
    /*var_dump($value);
    die($sql);*/

    $statement = $mysqli->prepare($sql);

    if(count($value) != 0)
    {
        $statement->bind_param($type , ...$value);
    }
    $statement->execute();
    $statement->store_result();

    return $statement;
}

?>