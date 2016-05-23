<?php
namespace Lapsic;
include_once(dirname(dirname(__FILE__)).'/config/config.php');

include_once('super.php');  

        ini_set('display_startup_errors',1);
        ini_set('display_errors',1);
        error_reporting(-1);
        
$plus_24        = 86400000;

//$element        = new $lapsic_user($db);
$element        = new LapsicPhoto($db);
$notification   = new LapsicNotification($db);
$already_timed  = true;

$debuggy        = false;

$ret            = false;
$res_ntf        = false;
$res_timer      = false;
$no_login       = false;

$time_up            = isset($_GET["time"])&& trim($_GET["time"])!="" && is_numeric($_GET["time"])	? (int)$_GET["time"]	: 0;
    
if(isset($_SESSION['lapsic_login']) && $_SESSION['lapsic_login']==true && (isset($time_up) && $time_up != ''))
{
    $no_login   = true;
    
    if(isset($id)) 
    {    	
    	if(!$element->GetElement($id))
        {
    		header('Location: index.php?resp_code=615');
    		exit ();
    	}
    }
    /**
     * CONTROLLO CHE NON SIA UNA FOTO DELL'UTENTE CHE STA VOTANDO
     */
    if($element->id_owner != $lapsic_user->id)
    {     
        $own_photo = true;
        if($debuggy) echo 'NON MIA FOTO <BR>';
        /**
         * CONTROLLO CHE NON ABBIA GIA' VOTATO LA FOTO NELLE ULTIME 24 ORE
         */
        $ParametersList['pagination']           = true;
        $ParametersList['record']   = $element->id;    
        $ParametersList['type']         = 'image';
        $ParametersList['elements_in_page']     = 30;
        $ParametersList['source']   = $lapsic_user->id;
        $numb_timed = $notification::GetNumberOfTimed($ParametersList);
        //var_dump($numb_timed);
        //echo sizeof($numb_timed);
        if($debuggy) echo 'NUMERO DI VOLTE VOTATA NELLE PASSATE 24 ORE - '.$numb_timed->getTotalItemCount().' <BR>';
        if( $numb_timed->getTotalItemCount() == 0 )
        {
            if($debuggy) echo 'CALCOLO IL NUOVO TEMPO DI FINE, +24 <BR>';
            $current        = $element->time_left;
            
            //$new_time       = $current + $plus_24;
            
            //---$time_up
            if($debuggy) echo 'time_up '.$time_up;
            
            $date_formt = new   \DateTime($current);
            $date_formt->add(new  \DateInterval('PT'.$time_up.'H'));
            $new_time       =   $date_formt->format('Y-m-d H:i:s');  
            //$lapsic_photo->time_left                    = $date_formt->format('Y-m-d H:i:s:u');
            if($debuggy) echo '<br>'.$new_time.'<br>';
                    
            $element->time_left = $new_time; //$date_formt->format('Y-m-d H:i:s:u');
            
            $res            = $element->update();
            if($res) 
            {    	
                if($debuggy) echo 'AGGIORNATO TEMPO CON SUCCESSO <BR>';
                $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG, "Donazione di tempo");                            
                $ret		= $action->Insert();
            
                // proseguo inserendo la notifica          
                $notification->type                  = 'image';
                $notification->id_record             = $id;
                $notification->id_user_source        = $lapsic_user->id;
                $notification->id_user_dest          = $element->id_owner;
                $notification->created_by            = $lapsic_user->id;
                $notification->status                = '0';
                  
                $res_ntf                             = $notification->Insert();
                  
                if($res_ntf) 
                {    			            
                    if($debuggy) echo 'INSERITO NOTIFICA CON SUCCESSO <BR>'; 
                    
                    $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG, "Inserimento notifica");                            
                    $ret		= $action->Insert();
                    
                    
                    $ParametersList['pagination']           = true;
                    $ParametersList['elements_in_page']     = 10;
                    $ParametersList['type']                 = 'timer';
                    $ParametersList['source']               = $lapsic_user->id;
                    $ParametersList['own_element']          = $element->id_owner;
                    
                    $timers 			= LapsicNotification::GetElementsListRelation($ParametersList);
                     
                    if($debuggy) echo 'CERCO SE ESISTE UNA RELAZIONE UGUALE'.$timers->getTotalItemCount().' <BR>';   
                    
                    if($timers->getTotalItemCount() <= 1)
                    {
                        if($debuggy) echo 'NON ESISTE QUINDI INSERISCO <BR>'; 
                        
                        $notification->type                  = 'timer';
                        $notification->id_record             = $element->id_owner;
                        $notification->id_user_source        = $lapsic_user->id;
                        $notification->id_user_dest          = $element->id_owner;
                        $notification->created_by            = $lapsic_user->id;
                        $notification->status                = '0';
                          
                        $res_timer                           = $notification->Insert();
                          
                        if($res_timer) 
                        {    			      
                            if($debuggy) echo 'RELAZIONE INSERITA CON SUCCESSO <BR>';        
                            $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG, "Inserimento notifica");                            
                            $ret		= $action->Insert();
                        }
                    }
                    else
                    {
                        $res_timer = true;
                        if($debuggy) echo 'stai seguendo sto utente <BR>';
                    }
                }
                else
                {
                    if($debuggy) echo 'ERRORE INSERENDO LA NUOVA NOTIFICA <BR>';
                }
            }
            else
            {
                if($debuggy) echo 'ERRORE AGGIORNANDO IL TEMPO <BR>';
            }
        }
        else
        {
          $already_timed    = false;  
        }
    }
    else
    {
        $own_photo = false;
    }
}
else
{
    $no_login   = false;
}
/*
$notification->type                  = 'timer';
$notification->id_record             = $id;
$notification->id_user_source        = $lapsic_user->id;
$notification->id_user_dest          = $element->id;
$notification->created_by            = $lapsic_user->id;
$notification->status                = '0';
  
$res_timer                           = $notification->Insert();
  
if($res_timer) 
{    			             
    $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG, "Inserimento notifica");                            
    $ret		= $action->Insert();
}*/

if($no_login && $already_timed && $own_photo && $ret && $res_ntf && $res_timer) 
{
    if($debuggy)
    {
        var_dump($already_timed); echo '<br>';
        var_dump($own_photo); echo '<br>';
        var_dump($ret); echo '<br>';
        var_dump($res_ntf); echo '<br>';
        var_dump($res_timer); echo '<br>';
        var_dump($no_login); echo '<br>';
    }
    //echo $new_time;
    echo json_encode(array('esito'=>'0','date'=>$new_time));
} 
else 
{
    if(!$no_login)
    {
        echo json_encode(array('esito'=>'1','error'=>'2'));
        //echo '2';
    }
    elseif(!$already_timed)
    {
        echo json_encode(array('esito'=>'1','error'=>'0'));
        //echo '0';
    }
    elseif(!$own_photo)
    {
        echo json_encode(array('esito'=>'1','error'=>'1'));
        //echo '1';
    }
    else
    {
        echo json_encode(array('esito'=>'1','error'=>'generic'));
        //echo 'error';
    }
}
 
?>