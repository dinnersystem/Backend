<?php
namespace user;
use \other\check_valid;

function change_password($old_password ,$new_password)
{
    $self = unserialize($_SESSION['me']);

    $old_password = check_valid::white_list($old_password ,check_valid::$white_list_pattern);
    $new_password = check_valid::pswd_check($new_password);

    $sql = "UPDATE `dinnersys`.`users`
        SET `password` = ?
        WHERE `users`.`id` = ? AND `users`.`password` = ?;";
    
    $mysqli = $_SESSION['sql_server'];
    $statement = $mysqli->prepare($sql);
    
    $statement->bind_param('sis', $new_password , $self->id ,$old_password);
    $statement->execute();
    if($mysqli->affected_rows == 0) // When the 'where clause' is not true
        throw new \Exception("Wrong password.");
    
    $self->password = $new_password;
    return $self;
}

?>