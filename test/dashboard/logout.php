<?php
session_start();
if(isset($_SESSION['bologin']))  {
	unset($_SESSION['bologin']); 
	unset($_SESSION['dashboard_iduser']);
	unset($_SESSION['nome']);
}
session_unset();
session_destroy();

header('Location: login.php?exit=1');
exit ();
?>