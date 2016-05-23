<?php

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

// Instantiate the CPANEL object.
require_once "/usr/local/cpanel/php/cpanel.php";
 echo 'post require<br>';
// Connect to cPanel - only do this once.
$cpanel = new cPanel();
 echo 'post cpanel<br>'; 
// Get domain user data.
$get_userdata = $cpanel->uapi(
    'DomainInfo', 'domains_data',
    array(
        'format'    => 'hash',
    )
);

 echo 'post cpanel-><br>'; 
var_dump($get_userdata);

?>