<?php
include_once(dirname(dirname(__FILE__)).'/config/config.php');
//include_once(Class_PATH.'Class_update.php');
$_text 			= isset($_GET["current"])			? trim($_GET["current"])			: NULL;
echo (Update::CheckUpdate($_text));

?>