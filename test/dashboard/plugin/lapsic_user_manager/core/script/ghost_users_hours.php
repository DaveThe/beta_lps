<?php
    namespace Lapsic;
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

include_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/config/config.php');
define("ID_USER_LOG", 0);

include_once(ABSPATH.'include/db.php');
$db = DBConnect();

$id = rand(1, 3000);
$n  = rand(2,28);
echo 'Photo '.$id.'<br>';
echo 'User '.$n;

if( isset($id) && $id != '')
{
    
    $plus_24        = 86400000;
    
    $lapsic_user    = new LapsicUser($db);    
    $element        = new LapsicPhoto($db);
    $notification   = new LapsicNotification($db);
    
	if(!$element->GetElement($id))
    {
	   echo 'immagine non trovata...riprova';
       //exit();	  
	   header('Location: ghost_users_hours.php');
	   exit (); 
	}
    
    if(!$lapsic_user->GetElement($n))
    {
   	    echo 'boooom errore';
        	  
        header('Location: ghost_users_hours.php');
        exit (); 
	}
     
    if($element->id_owner == $lapsic_user->id)
    {     
		echo 'Non puoi mica votare la tua stessa foto';
        exit();
	}
      
    $current        = $element->time_left;
    
    $date_formt = new   \DateTime($current);
    $date_formt->add(new  \DateInterval('P1D'));
    $new_time       =   $date_formt->format('Y-m-d H:i:s');  
        
    
    //$new_time       = $current + $plus_24;
    
    $element->time_left = $new_time;
    
    $res            = $element->update();
    if($res) 
    {    			             
        $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG, "Donazione di tempo");                            
        $ret		= $action->Insert();
    }
    
    $notification->type                  = 'image';
    $notification->id_record             = $id;
    $notification->id_user_source        = $lapsic_user->id;
    $notification->id_user_dest          = $element->id_owner;
    $notification->created_by            = $lapsic_user->id;
    $notification->status                = '0';
      
    $res_ntf                             = $notification->Insert();
      
    if($res_ntf) 
    {    			             
        $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG, "Inserimento notifica");                            
        $ret		= $action->Insert();
    }
    
    
    $ParametersList['db_adapter']           = $db;
    $ParametersList['page']                 = 1;
    $ParametersList['pagination']           = true;
    $ParametersList['elements_in_page']     = 10;
    $ParametersList['type']                 = 'timer';
    $ParametersList['own_element']          = $lapsic_user->id;
    $ParametersList['source']               = $element->id_owner;
    
    $timers 			= LapsicNotification::GetElementsListRelation($ParametersList);
    
    if($timers->getTotalItemCount() <= 1)
    {
        
        $notification->type                  = 'timer';
        $notification->id_record             = $element->id_owner;
        $notification->id_user_source        = $lapsic_user->id;
        $notification->id_user_dest          = $element->id_owner;
        $notification->created_by            = $lapsic_user->id;
        $notification->status                = '0';
          
        $res_tmr                             = $notification->Insert();
          
        if($res_tmr) 
        {    			             
            $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG, "Inserimento notifica");                            
            $ret		= $action->Insert();
        }
    }
    else
    {
        echo 'stai già seguendo sto utente';
    }
    
    if($ret && $res_tmr && $res_ntf) 
    {
        echo 'tutto ok';
    } 
    else 
    {
        echo 'error';
    }
}


?>