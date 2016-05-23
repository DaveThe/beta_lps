<?php
    namespace Lapsic;
    
    session_start();
    
    /**
     * ERROR TOGGLE 
     */
    if(true)
    {
        ini_set('display_startup_errors',1);
        ini_set('display_errors',1);
        error_reporting(-1);
    }
    /**
     * END ERROR TOGGLE 
     */        
    
	include_once(ABSPATH.'include/db.php');
	$db = DBConnect();
	
    include_once('parameters.php');
	 
    define("ID_USER_LOG", 	(isset($_SESSION['lapsic_iduser'])) ? $_SESSION['lapsic_iduser'] : 0 );
               
	/***** RECUPERO SETTINGS DEL PROGETTO *******/	
	/*$settings = new Setting($db);
	if(!$settings->getElement()) {
		header('Location: error/500.php?resp_code=615');
		exit ();
	}*/
    $lapsic_user  = new LapsicUser($db);
	/********************************************/
         
	//CONTROLLO SE L'UTENTE E' LOGGATO E CARICO I PERMESSI  && (isset($resp_code) && $resp_code != '1')
    if(PAGE_NAME != 'WELCOME' && PAGE_NAME != 'LOGIN_SOCIAL' && (isset($_SESSION['lapsic_logged']) && $_SESSION['lapsic_logged']==true))
    {  
    	LapsicUser::CheckLogin();
    	if(!$lapsic_user->GetElement($_SESSION['lapsic_iduser']))
        {
    		header('Location: error/500.php?resp_code=615');
    		exit ();
    	}
        $_SESSION['lapsic_logged'] = true;
        
        if(!isset($_GET['exit']) && PAGE_NAME != 'PROFILE_EDIT' && $lapsic_user->status == '2')
        {
    		header('Location: profile_edit.php?id='.$lapsic_user->id.'&resp_code=12');
    		exit ();            
        }
    }
    else
    {
        if(isset($_SESSION['lapsic_login']) && $_SESSION['lapsic_login']==true)
        {
            $_SESSION['lapsic_logged'] = true;
            header('Location: index.php');
            exit ();
        }
    }    
    
    function ElabImg($path,$img)
    {
        try
        {
            $width   = 0;
            $height  = 0;
            $name     = '';
            if (($pos = strpos($img, ".")) !== FALSE) {	
            	
            	$ext = substr($img, $pos+1); 
                //echo '<br>ext -'.$ext;
                
                $img_name = str_replace('.'.$ext,'', $img); 
                //echo '<br>img_name -'.$img_name;
                //var_dump(glob('../'.$path.$img_name."*.".$ext));
                //echo '<br>'.dirname(dirname(__FILE__)).$path.$img_name."*.".$ext;
                //echo $path.$img_name."*.".$ext;
                $new = glob($path.$img_name."*.".$ext);
                if( !isset( $new[0] )) { return array('error' => 1); }
                $new = $new[0];
                $name   = $new;
                //echo '<br>new -'.$new;
                //print_r($new);
            	//echo $test;
            	
            	if (($pos = strpos($new, "_")) !== FALSE) {
            		
            		$test = str_replace('.'.$ext,'',substr($new, $pos+1)); 
            
            		//echo '<br>'.$test;
            		
            		if (($pos = strpos($test, "X")) !== FALSE) {
            		
            			$dim = explode("X", $test);
                        if(sizeof($dim)>0)
                        {
                            $width   = $dim[0];
                            $height  = $dim[1];
                        }
            		}
            	}
            }
            
            return array(
                            'error'     => 0,
                            'name'      => $name,
                            'width'     => $width,
                            'height'    => $height,
                        );
        }               
        catch(Exception $e)
        {
            return array('error' => 1);
        }
    }
    
    /*
    function adaptTime($exp_date)
    {                
        // Count down milliseconds = server_end - server_now = client_end - client_now
        $server_end = $exp_date * 1000;
        $server_now = time() * 1000;
        //$client_now = new Date().getTime();
        $end = $server_end - $server_now;// + $client_now; // this is the real end time
        
        return $end;
    } 
    */      
        
    if((!isset($_SESSION['lapsic_logged']) || $_SESSION['lapsic_logged'] == false) && MODE != 'LOCALE') {
        include_once('Social.php');
        //$s_login = new Social();
    }
    elseif((PAGE_NAME == 'EDIT_PHOTO' || PAGE_NAME == 'PHOTO' || PAGE_NAME == 'SNAPSHOT') && MODE != 'LOCALE' )
    {
        include_once('Social.php');
    }     
    
    include_once('functions_positioning.php');
?>