<?php 
namespace Dashboard;
    ini_set('display_startup_errors',1);
    ini_set('display_errors',1);
    error_reporting(-1);
    
include_once(dirname(__FILE__).'/class/Secret.php');

$sec = new Secret();
echo $sec->decript(base64_decode($_GET['text']) );
?>