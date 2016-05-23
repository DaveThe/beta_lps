<?php
	include_once('singleton_parameters.php');
    if($_SERVER['REQUEST_METHOD']!="")
    {           
        if ( ( (phpversion() < "5.4") ? (session_id() == '' || !isset($_SESSION)) : session_status() == PHP_SESSION_NONE ) ) 
        {
            session_start();
        }
        else
        {            
            session_destroy();
            session_start();
        }
        $single = SingApi::getInstance();
        $single->setPost($_POST);
        $single->setMethd($_SERVER['REQUEST_METHOD']);
    }
?>