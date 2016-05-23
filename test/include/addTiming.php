<?php
namespace Lapsic;
include_once(dirname(dirname(__FILE__)).'/config/config.php');

include_once('super.php');  

        ini_set('display_startup_errors',1);
        ini_set('display_errors',1);
        error_reporting(-1);
        
$plus_24        = 86400000;

$element        = new $lapsic_user($db);
$notification   = new LapsicNotification($db);


if(isset($id)) {
	
	if(!$element->GetElement($id)){
		header('Location: index.php?resp_code=615');
		exit ();
	}
}
         
$notification->type                  = 'timer';
$notification->id_record             = $id;
$notification->id_user_source        = $lapsic_user->id;
$notification->id_user_dest          = $element->id;
$notification->created_by            = $lapsic_user->id;
$notification->status                = '0';
  
$res_ntf                             = $notification->Insert();
  
if($res_ntf) 
{    			             
    $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG, "Inserimento notifica");                            
    $ret		= $action->Insert();
}

if($ret) 
{
    echo 'utente segue';
} 
else 
{
    echo 'error';
}
 
?>