<?php

namespace Lapsic;
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

include_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/config/config.php');
define("ID_USER_LOG", 0);

include_once(ABSPATH.'include/db.php');
$db = DBConnect();


$notification   = new LapsicNotification($db);

$ret            = $notification->CallNotify();

echo $ret;

$ret            = $notification->CallCounter();

echo $ret;

?>