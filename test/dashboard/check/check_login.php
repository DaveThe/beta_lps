<?php
namespace Dashboard;

    $dati	= array();
    
    $exit 	= isset($_GET['exit']) && is_numeric(trim($_GET['exit']))		? $_GET['exit']		: NULL;
    
    if(isset($exit))
    {
    		$respok	=	'Logout avvenuto con successo';
    }
    else
    {
    
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
    	if (isset($_POST['utente']) && (trim($_POST['utente']) != '')) 
        {
    		$utente   = trim($_POST['utente']);
    	} else {
    		$errors[]  = "Digitare uno username<br/>";
    	}
    	
    	if (isset($_POST['password']) && (trim($_POST['password']) != '')) 
        {
    		$password = trim($_POST['password']);
    	} 
        else 
        {
    		$errors[]  = "Digitare una password<br/>";
    	}
    	
    	if( sizeof($errors) == 0 )
        {
            $Dashboard_user             = new User($db);
            $data = $Dashboard_user->Login($utente, $password);
            if( isset($data) && $data != NULL )
            {
            	$_SESSION['dashboard_login']			= true;
            	$_SESSION['dashboard_iduser']			= $data;
            	//$_SESSION['tipo']				= $dati['type_user'];			
                //$_SESSION['dashboard_nickname']			= $dati['nickname'];
            	//$_SESSION['dashboard_username']			= $dati['username'];
            	//$_SESSION['prj_color']			= $dati['prj_color'];
            	//$_SESSION['avatar']  			= $dati['img'];
            	//$_SESSION['company']  			= $dati['company'];
            	    			
            	header('location:index.php');
            	exit ();
            }
            else
            {
            	$errors[]	= 'Login errato';
            }
    	}
    }
?>