<?php
namespace user;

class operation
{
    public static $oper = [
        'guest' => [
            'login' => 'login',
            'logout' => 'logout'
        ],
        'normal' => [
            'change_password' => 'change_password',
            'show_dish' => 'show_dish',
            'select_self' => 'show_order',
            'make_self_order' => 'make_order',
            'delete_self' => 'delete_order',
            'payment_self' => 'set_payment',
            'get_pos' => 'get_pos'
        ],
        'dinnerman' => [
            'change_password' => 'change_password',
            'show_dish' => 'show_dish',
            'select_class' => 'show_order',
        ],
        'cafeteria' => [
            'change_password' => 'change_password',
            'show_dish' => 'show_dish',
            'update_dish' => 'update_dish',
            'select_other' => 'show_order',
            'delete_everyone' => 'delete_order'
        ],
        'factory' => [
            'change_password' => 'change_password',
            'show_dish' => 'show_dish',
            'update_dish' => 'update_dish',
            'error_report' => 'error_report',
            'select_facto' => 'show_order'
        ],
        'admin' => [
            'change_password' => 'change_password',
            'update_dish' => 'update_dish',
            'select_other' => 'show_order' ,
            'delete_everyone' => 'delete_order',
        ]
    ];

    public static function get_oper($prev)
    {
        return self::$oper[$prev];
    }
}



?>