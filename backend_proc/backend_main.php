<?php
namespace backend_proc;

class backend_main
{
    public $order_handler;
    public $input;
    
    function __construct($input = null)
    {
        require_once (__DIR__ . '/order_handler.php');
        require_once (__DIR__ . '/config.php');

        
        require_once (__DIR__ . '/../json/json_format.php'); 
        require_once (__DIR__ . '/../json/json_output.php'); 
        require_once (__DIR__ . '/../json/json_adjust.php');



        require_once (__DIR__ . '/../food/limitable/limitable.php');
        require_once (__DIR__ . '/../food/limitable/fetch_limitable.php');

        require_once (__DIR__ . '/../food/buffet/buffet.php');
        require_once (__DIR__ . '/../food/buffet/get_buffets.php');
        require_once (__DIR__ . '/../food/buffet/buffet_func.php');

        require_once (__DIR__ . '/../food/department/department.php');
        require_once (__DIR__ . '/../food/department/get_department.php');

        require_once (__DIR__ . '/../food/dish/update_dish.php');
        require_once (__DIR__ . '/../food/dish/dish.php');
        require_once (__DIR__ . '/../food/dish/get_dish.php');
        require_once (__DIR__ . '/../food/dish/updatable.php');
        require_once (__DIR__ . '/../food/dish/show_dish.php');
        require_once (__DIR__ . '/../food/dish/best_seller.php');

        require_once (__DIR__ . '/../food/factory/factory.php');
        require_once (__DIR__ . '/../food/factory/get_factory.php');

        require_once (__DIR__ . '/../food/vege/vege.php');
        


        require_once (__DIR__ . '/../order/delete_order/delete.php');
        require_once (__DIR__ . '/../order/delete_order/delete_auth.php');

        require_once (__DIR__ . '/../order/make_order/get_user_id.php');
        require_once (__DIR__ . '/../order/make_order/make_order.php');
        require_once (__DIR__ . '/../order/make_order/check_time.php');
        require_once (__DIR__ . '/../order/make_order/check_dish.php');

        require_once (__DIR__ . '/../order/money_info/payment/payment.php');
        require_once (__DIR__ . '/../order/money_info/payment/payment_auth.php');
        require_once (__DIR__ . '/../order/money_info/payment/payment.php');
        require_once (__DIR__ . '/../order/money_info/payment/set_payment.php');
        require_once (__DIR__ . '/../order/money_info/payment/raw_auth.php');
        require_once (__DIR__ . '/../order/money_info/get_payments.php');
        require_once (__DIR__ . '/../order/money_info/money_info.php');

        require_once (__DIR__ . '/../order/select_order/create_statement.php');
        require_once (__DIR__ . '/../order/select_order/extend_record.php');
        require_once (__DIR__ . '/../order/select_order/get_orders.php');
        require_once (__DIR__ . '/../order/select_order/select_sql.php');
        require_once (__DIR__ . '/../order/select_order/select_order.php');
        require_once (__DIR__ . '/../order/select_order/get_factory_id.php');

        require_once (__DIR__ . '/../order/order.php');



        require_once (__DIR__ . '/../pos/debit.php');
        require_once (__DIR__ . '/../pos/get_pos.php');
        require_once (__DIR__ . '/../pos/announce.php');



        require_once (__DIR__ . '/../punish/attempt.php');
        require_once (__DIR__ . '/../punish/check.php');


        
        require_once (__DIR__ . '/../other/check_valid.php');
        require_once (__DIR__ . '/../other/date_api.php');
        require_once (__DIR__ . '/../other/get_ip.php');
        require_once (__DIR__ . '/../other/init_vars.php');
        require_once (__DIR__ . '/../other/sql_server.php');
        require_once (__DIR__ . '/../other/error_report.php');

        require_once (__DIR__ . '/../other/log/make_log.php');
        require_once (__DIR__ . '/../other/log/make_error_log.php');
        

        
        require_once (__DIR__ . '/../user/class/user_class.php');
        require_once (__DIR__ . '/../user/class/get_class.php');

        require_once (__DIR__ . '/../user/oper_prev/get_able_oper.php');
        require_once (__DIR__ . '/../user/oper_prev/operation.php');
        require_once (__DIR__ . '/../user/oper_prev/previleges.php');

        require_once (__DIR__ . '/../user/change_password.php');
        require_once (__DIR__ . '/../user/get_user.php');
        require_once (__DIR__ . '/../user/logout.php');
        require_once (__DIR__ . '/../user/user.php');

        require_once (__DIR__ . '/../user/login/login.php');
        require_once (__DIR__ . '/../user/login/raw_auth.php');
        $this->input = $input;
    }
    
    function run()
    {
        if($this->input == null) {
            $this->order_handler = new order_handler($_REQUEST);  
        } else {
            $this->order_handler = new order_handler($this->input);  
        }
        return $this->order_handler->process_order();
    }
}

?>