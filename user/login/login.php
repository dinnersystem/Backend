<?php
namespace user\login;

use \other\check_valid;
use \user\user;

function update_device($uid, $device)
{
    $sql_command = "UPDATE `dinnersys`.`users` SET `device_id` = ? WHERE `id` = ?;";
    $mysqli = $_SESSION['sql_server'];
    $statement = $mysqli->prepare($sql_command);
    $statement->bind_param('is', $uid, $device);
    $statement->execute();
}

function get_data($login_id, $org_id, $class, $org)
{
    $sql_command = "SELECT U.id ,UI.name ,U.class_id ,UI.is_vegetarian ,UI.seat_id ,UI.bank_id ,U.prev_sum ,U.login_id ,U.password ,U.PIN ,UI.daily_limit ,U.organization_id
        FROM `dinnersys`.`users` AS U ,`dinnersys`.`user_information` AS UI
        WHERE U.info_id = UI.id AND U.login_id = ? AND U.organization_id = ?;";
    $mysqli = $_SESSION['sql_server'];
    $statement = $mysqli->prepare($sql_command);
    $statement->bind_param('ss', $login_id, $org_id);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($id, $name, $class_id, $is_vege, $seat_id, $bank_id, $prev_sum, $login_id, $pswd, $PIN, $daily_limit, $org_id);
    if ($statement->fetch()) {
        $account = new user($id, $name, $class[strval($class_id)], $seat_id, $org[$org_id]);
        $account->private_init($prev_sum, new \food\vege($is_vege), $login_id, $bank_id, $pswd, $PIN, $daily_limit);
    }
    return $account;
}

function login($login_id, $password, $org_id, $device_id, $req_id)
{
    $login_id = check_valid::white_list($login_id, check_valid::$white_list_pattern);
    $device_id = urldecode($device_id);
    $device_id = check_valid::regex_check($device_id, check_valid::$device_regex);
    $org_id = check_valid::white_list($org_id, check_valid::$only_number);
    
    $class = \user\get_class();
    $org = \user\get_organization();
    $account = get_data($login_id, $org_id, $class, $org);
    if ($account == null)  throw new \Exception("No user");
    
    \punish\check($account->id, "login");
    try {
        $raw_auth = raw_auth($login_id, $org_id, $password);
        if (!$raw_auth) throw new \Exception("Wrong password");
    } catch (\Exception $e) {
        \punish\attempt($account->id, $req_id, "login");
        throw $e;
    }
    
    update_device($account->id, $device_id);
    $_SESSION['me'] = serialize($account);
    \other\init_vars();
    return $account;
}
