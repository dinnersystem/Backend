<?php
    # this file requires a bom header to let ios plugin run
    ini_set('display_errors' ,1);
    error_reporting(0);
    # mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    require_once(__DIR__ . "/backend_proc/backend_main.php");
    
    date_default_timezone_set('Asia/Taipei');
    $backend_main = new backend_proc\backend_main();
    $result = $backend_main->run();

    if(is_string($result))
        echo $result;
    else
        echo \json\json_output::output($result);
?>
