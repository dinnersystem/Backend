<?php
namespace order\select_order;
use other\check_valid;
use other\date_api;

function select_order($param)
{    
    $param['user_id'] = check_valid::white_list_null($param['user_id'] ?? NULL ,check_valid::$integers);
    $param['payment'] = check_valid::bool_null_check($param['payment'] ?? NULL);
    if($param['esti_start'] ?? NULL != null) $param['esti_start'] = date_api::is_valid_time($param['esti_start'])->format('Y/m/d-H:i:s');
    if($param['esti_end'] ?? NULL != null) $param['esti_end'] = date_api::is_valid_time($param['esti_end'])->format('Y/m/d-H:i:s');
    $param['factory_id'] = check_valid::white_list_null($param['factory_id'] ?? NULL ,check_valid::$only_number);
    $param['person'] = check_valid::bool_null_check($param['person'] ?? NULL);
    $param['class'] = check_valid::bool_null_check($param['class'] ?? NULL);
    $param['oid'] = check_valid::white_list_null($param['oid'] ?? NULL ,check_valid::$only_number);

    $statement = create_statement($param); 
    $result = get_orders($statement);
    $result = extend_payment($result);
    $result = extend_buffet($result ,($param["history"] ?? NULL == "true")); 

    return $result;
}

?>