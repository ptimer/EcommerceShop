<?php

if(!function_exists('Error500')) {
    function Error500($errno, $errmsg){
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $errno $errmsg  \n";
        error_log($message, 3, '../../../errors.log');
        header('Location: ../../../view/error/error_500.php');
        die();
    }
}

set_error_handler("Error500");