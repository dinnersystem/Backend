<?php
namespace user;

class operation
{
    public static $oper = [
        'guest' => [
            'login' => 'login',
            'logout' => 'logout',
            'show_organization' => 'show_organization'
        ],
        'normal' => [
            'change_password' => 'change_password',
            'show_dish' => 'show_dish',
            'select_self' => 'show_order',
            'make_self_order' => 'make_order',
            'delete_self' => 'delete_order',
            'payment_self' => 'set_payment',
            'get_pos' => 'get_pos',
            'show_factory' => 'show_factory'
        ],
        'dinnerman' => [
            'show_dish' => 'show_dish',
            'select_class' => 'show_order',
            'show_factory' => 'show_factory'
        ],
        'cafeteria' => [
            'change_password' => 'change_password',
            'show_dish' => 'show_dish',
            'update_dish' => 'update_dish',
            'select_other' => 'show_order',
            'delete_everyone' => 'delete_order',
            'show_factory' => 'show_factory'
        ],
        'factory' => [
            'change_password' => 'change_password',
            'show_dish' => 'show_dish',
            'update_dish' => 'update_dish',
            'error_report' => 'error_report',
            'select_facto' => 'show_order',
            'show_factory' => 'show_factory'
        ],
        'admin' => [
            'change_password' => 'change_password',
            'update_dish' => 'update_dish',
            'select_prime' => 'show_order' ,
            'delete_everyone' => 'delete_order',
            'show_factory' => 'show_factory'
        ]
    ];

    public static function get_oper($prev)
    {
        return self::$oper[$prev];
    }
}



?>
