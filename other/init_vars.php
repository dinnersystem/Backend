<?php
namespace other;

/* All these variables should be stored in application layer cache instead of user layer cache */
function init_vars() {
    $everyone = false; $cid = null;
    $self = unserialize($_SESSION['me']);
    if(array_key_exists("select_self" ,$self->services)) $cid = $self->class->id;
    if(array_key_exists("select_class" ,$self->services)) $cid = $self->class->id;
    if(array_key_exists("select_other" ,$self->services)) { $cid = null; $everyone = true; }
    if(array_key_exists("select_facto" ,$self->services)) { $cid = null; $everyone = true; }
    
    $_SESSION['organization'] = serialize(\user\get_organization());
    $_SESSION['user'] = serialize(\user\get_user($cid ,$everyone));
    $_SESSION['factory'] = serialize(\food\get_factory());
    $_SESSION['department'] = serialize(\food\get_department());
    $_SESSION['dish'] = serialize(\food\get_dish());
    session_write_close();
}

?>