<?php
date_default_timezone_set ('UTC');
    include('mode.php');
    
    switch (MODE) {
        
        case 'TEST':
            
            	set_include_path(
            		dirname(dirname(__FILE__)).'/Lib' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/config/class' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/config/social/class' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/config' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/include' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/check' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/js/script' . PATH_SEPARATOR .
            		get_include_path()
            	);
                
                require_once('Zend/Loader/StandardAutoloader.php');
                define("ABSPATH",   		dirname(dirname(dirname(__FILE__))) . '/test/');
            
            break;            
        case 'LOCALE':
            
            	set_include_path(
            		dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/Lib' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/config/class' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/config/social/class' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/config' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/include' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/check' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/js/script' . PATH_SEPARATOR .
            		get_include_path()
            	);
                
                require_once('Zend/Loader/StandardAutoloader.php');
                define("ABSPATH",   		dirname(dirname(__FILE__)) . '/');
                
            break;
        case 'PROD':
            
            	set_include_path(
            		dirname(dirname(__FILE__)).'/Lib' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/config/class' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/config/social/class' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/config' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/include' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/check' . PATH_SEPARATOR .
            		dirname(dirname(__FILE__)).'/js/script' . PATH_SEPARATOR .
            		get_include_path()
            	);
                
                require_once('Zend/Loader/StandardAutoloader.php');
                define("ABSPATH",   		dirname(dirname(__FILE__)) . '/');
                
            break;
    }
	
    
	
    
	$loader = new Zend\Loader\StandardAutoloader(
        array(            
            'namespaces' => array(
                                    'Lapsic' => dirname(__DIR__) . '/config/class',
                                    
                                ),
            'fallback_autoloader' => true,
            'autoregister_zf' => true
        )
    );
    
	$loader->register();
    
        
    //-----------------------------------------------------------------------------------------------//
    
    define("LOGO_IMG", 	      'logo.png');
    define("NOME_PRJ", 	      'Lapsic');
    define("PREFIX", 	      '');
    define("LANG", 	          'IT');
    define("MAX_UPLOAD",      '3');
    define("PROD", 	          false);
	/*********** VAR PATH ******************/
	define("PLUGIN_CLASS_PATH", 'core/class/');
    define("PLUGIN_PATH", 		dirname(dirname(__FILE__)).'/plugin/');
    
	define("JAVA_PATH", 		'/');
	define("JAVA_THEMES_PATH", 	DASHBOARD_PATH.'themes/');
	define("JAVA_PLUGIN_PATH", 	DASHBOARD_PATH.'plugin/');
    define("MEDIA_PATH", 		DASHBOARD_PATH.'media/');
    define("PLUGIN_MEDIA_PATH",	DASHBOARD_PATH.'plugin/');        
    
    $area_setting = array (
                            'LOG',
                            'PLUGIN',
                            'THEMES'
                          );
    define("PAGE_NAME",			strtoupper (str_replace('.php','',basename($_SERVER['PHP_SELF']))));
                      	
	
    /*********** VAR PERMESSI **************/
    define("READ", 		1);
    define("WRITE", 	2);
    define("DELETE", 	3);
    define("PUBLISH", 	4);
    define("OWN_ONLY", 	5);
    /*********** END VAR PERMESSI **************/
    
    
    /*********** VAR LOG **************/
    define("CREATE", 	1);
    define("UPDATE", 	2);
    define("GET_DATA", 	5);
    define("ERROR", 	1);
    define("WARNING", 	0);
    define("LOGIN", 	6);
    define("LOGOUT", 	7);
    define("REGISTER", 	8);
    
    
    /*********** VAR GEN **************/
    define("ENABLE", 	'1');
    define("DISABLE", 	'0');
    define("DEV_MODE", 	true);
    
    /*********** DATE FORMAT **************/
    define("IT", 	  "d-m-Y H:i:s");
    define("IT_DATE", "d-m-Y");
    define("IT_DATE_SLASH", "d/m/Y");
    define("IT_EXT",  0);
    define("EN", 	  "Y-m-d H:i:s");
    define("EN_EXT",  1);
    
?>