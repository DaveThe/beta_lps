<?php


ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

date_default_timezone_set ('UTC');

echo date("Y-m-d H:i:s");

define('SECRET_K','1bcc659149198e25998264ba8d89456b');

echo '<br> ------------ TEST GETALLHEADER START -------------- <br>';

$headers = getallheaders();

print_r($headers);

echo '<br> ------------ TEST GETALLHEADER END -------------- <br>';



echo hash_hmac('sha256', $_POST['files'], SECRET_K);
