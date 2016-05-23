<?php
namespace Dashboard;

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

	include_once('check_request.php');
	if ( ( (phpversion() < "5.4") ? (session_id() == '' || !isset($_SESSION)) : session_status() == PHP_SESSION_NONE ) ) 
    {
        session_start();
    }
    
	Debug::EnableErrors();
	include_once(ABSPATH.'include/db.php');
	$db = DBConnect();
	
	$debug_key 		= (isset($_GET['key'] ) && trim($_GET['key']) != '' ) ? $_GET['key'] : NULL;
	if(PAGE_NAME != 'DEBUGGER'){ $debug_var	= new Debug(); $debug_var->CheckDebug($debug_key); }
    
    include_once('parameters.php');
	 
    define("ID_USER_LOG", 	(isset($_SESSION['dashboard_iduser'])) ? $_SESSION['dashboard_iduser'] : 0 );
               
	/***** RECUPERO SETTINGS DEL PROGETTO *******/	
	$settings = new Setting($db);
	if(!$settings->getElement()) {
		header('Location: error/500.php?resp_code=615');
		exit ();
	}
    $Dashboard_user  = new User($db);
	/********************************************/
    
	if(PAGE_NAME != 'LOGIN' && PAGE_NAME != 'LOCKSCREEN')
	{  
 	      $auth = NULL;
 	    if(function_exists('getallheaders'))
         {
            $headers = getallheaders();
            if(isset($headers['Authorization'])) $auth = $headers['Authorization'];
         }
         else
         { 
            
            function emu_getallheaders() {
               foreach($_SERVER as $name => $value)
                   
                    if(substr($name, 0, 5) == 'HTTP_')
                    { 
                        $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                    else if ($name == "CONTENT_TYPE") 
                    { 
                        $headers["Content-Type"] = $value; 
                    } 
                    else if ($name == "CONTENT_LENGTH") 
                    { 
                        $headers["Content-Length"] = $value; 
                    }     
                       
               return $headers;
            }
            
            $headers = emu_getallheaders();
            
            if(isset($headers['Authorization']))$auth = $headers['Authorization'];
            //var_dump($_ENV['HTTP_AUTHORIZATION']);
            //$auth = (isset($_ENV['HTTP_AUTHORIZATION']) && $_ENV['HTTP_AUTHORIZATION'] != NULL ) ? $_ENV['HTTP_AUTHORIZATION'] : NULL;
         }
    	  
		if(!isset($auth))
        { 
        	//CONTROLLO SE L'UTENTE E' LOGGATO E CARICO I PERMESSI
        	User::CheckLogin();
        	if(!$Dashboard_user->GetElement($_SESSION['dashboard_iduser']))
            {
        		header('Location: error/500.php?resp_code=615');
        		exit ();
        	}
        }
        else
        {
            $single                          = SingApi::getInstance();
            $_POST                           = $single->getPost();
            $_SERVER['REQUEST_METHOD']       = $single->getMethod();
            $permits		                 = new Permessi($db);
            $_SESSION['dashboard_iduser']    = $permits->CheckAPIKey($auth);
            
            if($_SERVER['REQUEST_METHOD']=="LINK")
            {    
                $array_dati=array('welcome' => 'api dashboard','esito'=>'1','err_desc'=>'','code_err'=>'','data'=>'prelevo le info da mandare al manager', 'LINK' => Log::GetElementsList($db, 20));
                
                header('Content-Type: application/json');
                echo json_encode($array_dati);
                exit (); 
            }
        }     
           
        $area     = $Dashboard_user->getUserArea();

        if(PAGE_SUB != '')
        {
            $sub_area = $area[PAGE_NAME]['sub_area'][PAGE_SUB];
        }
        //print_r($area);
                 
        /***** RECUPERO SETTINGS DEL PROGETTO *******/
        /*$Dashboard_user             = new User($db);
    	if(!$Dashboard_user->GetElement_user($_SESSION['dashboard_iduser'])) 
        {
    		header('Location: error/500.php?resp_code=615');
    		exit ();
    	}
        */
        /********************************************/
        
        /*********** CREO ISTANZA PLUGIN ************/
        $plugins	= new Plugin($Dashboard_user->username, $Dashboard_user->email, $db);
	    include_once('enable_plugin.php');
        /********************************************/
        
	}

?>