<?php
namespace user;

function get_user($cid ,$everyone)
{
    $mysqli = $_SESSION['sql_server'];
    $me = unserialize($_SESSION["me"]);
    //load all the users might be seen.
    
    $sql = "SELECT U.id ,UI.name ,U.class_id ,UI.seat_id
        FROM users AS U ,user_information AS UI 
        WHERE U.info_id = UI.id
        AND (U.prev_sum >= 4 OR ? OR U.id = ? OR U.class_id = ?)";
    
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('iii' ,$everyone ,$me->id ,$cid);

    $statement->execute();
    $statement->store_result();
    $statement->bind_result($uid ,$name ,$cid ,$sno);
    
    $class = unserialize($_SESSION['class']);
    $result = [];
    while($statement->fetch())
    {
        $result[$uid] = new user($uid ,$name ,$class[$cid] ,$sno);
    }
    
    return $result;
}

?>
