<?php
namespace other;

function init_vars()
{
    $_SESSION['factory'] = serialize(\food\get_factory());
    $_SESSION['department'] = serialize(\food\get_department());

    $cid = $fid = null;
    $everyone = false;
    $self = unserialize($_SESSION['me']);
    if(array_key_exists("select_self" ,$self->services))
        $cid = $self->class->id;
    if(array_key_exists("select_class" ,$self->services))
        $cid = $self->class->id;
    if(array_key_exists("select_other" ,$self->services))
    {
        $cid = null;
        $everyone = true;
    }
    if(array_key_exists("select_facto" ,$self->services))
    {
        $cid = null;
        $everyone = true;
    }
    
    $_SESSION['dish'] = serialize(\food\get_dish());
    $_SESSION['user'] = serialize(\user\get_user($cid ,$everyone));
    session_write_close();
}

?>