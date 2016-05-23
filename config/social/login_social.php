<?php
namespace Lapsic;
include_once(dirname(dirname(__FILE__)).'/config.php');

include_once('super.php');  
error_reporting(E_ALL);
ini_set("display_errors", 1);
//session_start();
//include_once('class/Social.php');

$db 			= DBConnect(); 
$ref	= isset($_GET['ref']) && trim($_GET['ref'])!=''?$_GET['ref']:NULL;

//CONTROLLO IL TYPE (FB o GO) cosi so se sto loggando con google o facebook, fb lo passo come get mentre go viene passato come post, ecco perchè c'è il doppio controllo

$type 	= isset($_GET['t']) && trim($_GET['t'])!=''?$_GET['t']:false; //controllo fb
if(!$type)
{
	$type 	= isset($_POST['t']) && trim($_POST['t'])!=''?$_POST['t']:false; //controllo google
}

if(!$type)
{
	header("location:/index.php"); //probabile manipolazione del link o l'utente cerca di arrivare in questa pagina, ritorno alla index
	exit;
}



//Per aumentare la sicurezza, controllo anche la variabile di sessione STATE per controllare se è partita un'istanza della classe di login
if (isset($_POST['state']) && isset($_SESSION['state'])) {
	if (!($_POST['state'] == $_SESSION['state'])) {
		header('HTTP/1.0 401 Unauthorized');
		exit;
	}
} else {
	// Commento temporaneo per i tests
	//header('HTTP/1.0 401 Unauthorized');
	//exit();
}

//if(!isset($_SESSION['user_login']) || $_SESSION['user_login']==false)
if(!isset($_SESSION['lapsic_login']) || $_SESSION['lapsic_login']==false)
{
	//UTENTE NON LOGGATO 
	
	//LOGIN
	
	$user_data = Social::getInstance()->login($type);

	//echo(json_encode($user_data));
    $lapsic_user             = new LapsicUser($db);
    $element_hashtag         = new LapsicHashTag($db);
    $data = $lapsic_user->LoginSocial($user_data['data']['email']);
    if( isset($data) && $data != NULL )
    {
    	$_SESSION['lapsic_login']			= true;
        $_SESSION['lapsic_logged']          = true;
    	$_SESSION['lapsic_iduser']			= $data;
        
        $action     = new LogAction($db, LOGIN, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG,'social login utente registrato');   
        $ret		= $action->Insert();
        
        echo(json_encode(array('esito'=>1, 'dati'=>$user_data, 'msg' => 'utente presente in db e loggato')));
    }
    else
    {                    
        $lapsic_user->nickname 			= $user_data['data']['nickname'];
        $lapsic_user->username 			= $user_data['data']['nickname'];
        $lapsic_user->name              = $user_data['data']['first_name'];
        $lapsic_user->surname           = $user_data['data']['last_name'];
    	$lapsic_user->email 			= $user_data['data']['email'];
        $lapsic_user->gender            = $user_data['data']['gender'];
        $lapsic_user->informativa       = '1';
        
        $url = $user_data['data']['picture'];
        $img_name = md5(microtime()).'.jpg';
        $img = dirname(dirname(dirname(__FILE__))).'/media/avatar/'.$img_name;
        file_put_contents($img, file_get_contents($url));
        $lapsic_user->img               = $img_name;
        $lapsic_user->created_by        = '0';
        $lapsic_user->status            = '2';
         
    	$res = $lapsic_user->insert();
        
    	if($res) 
        {    			 
    		$resp_code 			= 100;
            
            $action     = new LogAction($db, REGISTER, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG);                            
            $ret		= $action->Insert();
    	} 
        else 
        {
    		$resp_code 			= 105;	
    	}
        
        if ($ret)
        {   
            $element_hashtag->type_record = 'LapsicUser';
            $element_hashtag->id_record     = $lapsic_user->id;
            
            $element_hashtag->tag_original = $lapsic_user->nickname;
            $element_hashtag->tag_name = $lapsic_user->nickname;
            $res = $element_hashtag->insert();
            
    		if($res) {
    			$resp_code 			= 100;
                
                $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $element_hashtag->id, ID_USER_LOG, 'Inserimento hashtag: '.$tags);                            
                $ret		= $action->Insert();
    		} else {
    			$resp_code 			= 105;	
    		}
        }
        
    	if($ret) 
        {
            $_SESSION['lapsic_login']			= true;
            $_SESSION['lapsic_logged']          = true;
        	$_SESSION['lapsic_iduser']			= $lapsic_user->id;
            echo(json_encode(array('esito'=>1, 'dati'=>$user_data, 'msg' => 'registrazione utente avvenuta con successo')));
    	} 
        else 
        {
            echo(json_encode(array('esito'=>0, 'dati'=>$user_data, 'msg' => 'registrazione fallita')));
    	}
    }
}
else
{
    echo(json_encode(array('esito'=>4, 'msg' => 'Utente loggato in precedenza')));
}

?>