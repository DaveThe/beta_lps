<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
include('class/social_login.php');
$s_login = new Social();

$ref	= isset($_GET['ref']) && trim($_GET['ref'])!=''?$_GET['ref']:NULL;

//CONTROLLO IL TYPE (FB o GO) cosi so se sto loggando con google o facebook, fb lo passo come get mentre go viene passato come post, ecco perchè c'è il doppio controllo
$type 	= isset($_GET['t']) && trim($_GET['t'])!=''?$_GET['t']:NULL; //controllo fb
if(!isset($type))
{
	$type 	= isset($_POST['t']) && trim($_POST['t'])!=''?$_POST['t']:NULL; //controllo google
}

if(!isset($type))
{
	header("location:index.php"); //probabile manipolazione del link o l'utente cerca di arrivare in questa pagina, FUCK ritorni alla index
}

//Per aumentare la sicurezza, controllo anche la variabile di sessione STATE per controllare se è partita un'istanza della classe di login

if (isset($_POST['state']) && isset($_SESSION['state'])) {
	if (!($_POST['state'] == $_SESSION['state'])) {
		header('HTTP/1.0 401 Unauthorized');
		exit;
	}
} else {
	// Commento temporaneo per i tests
	/*header('HTTP/1.0 401 Unauthorized');
	exit();*/
}

if(!isset($_SESSION['loggato']) || $_SESSION['loggato']==false)
{

	//UTENTE NON LOGGATO 
	
	//LOGIN
	
	$user_data = $s_login->login($type);
	
	echo(json_encode($user_data));

}
else
{
	header("location:index.php");
}

?>