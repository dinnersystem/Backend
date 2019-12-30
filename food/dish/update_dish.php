<?php
namespace food;
use \other\check_valid;

function update_dish($id ,$dname ,$csum ,$vege ,$idle ,$daily_limit)
{
    $id = check_valid::white_list($id ,check_valid::$only_number); 
    $dname = htmlspecialchars($dname);
    $csum = check_valid::white_list($csum ,check_valid::$only_number);
    $vege = check_valid::vege_check($vege);
    $daily_limit = check_valid::white_list($daily_limit ,check_valid::$integers);
    if($idle != null) $idle = ($idle == 'true');

    $vege = new vege(null ,$vege);
    $vege = $vege->number;
    
    $row = get_dish($id)[$id];
    if($row == null || !$row->updatable()) 
        throw new \Exception("Access denied.");
    $same = (
        $row->name == $dname &&
        $row->charge == $csum  &&
        $row->vege->name == $vege &&
        $row->is_idle == $idle &&
        $row->daily_produce == $daily_limit
    );
    if($same) return "Nothing to update.";

    $mysqli = $_SESSION['sql_server'];
    $sql = "CALL update_dish(? ,? ,? ,? ,? ,?)";
    
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('isiiii' ,$id ,$dname ,$csum ,$vege ,$idle ,$daily_limit);
    $statement->execute();

    return "Successfully updated food.";
}

?>