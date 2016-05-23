<?php

	set_include_path(
		dirname(dirname(dirname(__FILE__))).'/dashboard/Lib' . PATH_SEPARATOR .
		dirname(dirname(dirname(__FILE__))).'/dashboard/class' . PATH_SEPARATOR .
		dirname(dirname(dirname(__FILE__))).'/dashboard/config' . PATH_SEPARATOR .
		dirname(dirname(dirname(__FILE__))).'/dashboard/include' . PATH_SEPARATOR .
		dirname(dirname(dirname(__FILE__))).'/dashboard/check' . PATH_SEPARATOR .
		dirname(dirname(dirname(__FILE__))).'/dashboard/js/script' . PATH_SEPARATOR .
		get_include_path()
	);
	
    //-----------------------------------------------------------------------------------------------//
    
    /*
     * SE CHIAMO I FILE DELLE CLASSI COME IL NOME DELLA CLASSE (ES. Utenti.php -> new Utenti() )
     * Posso usare questa funzione per non richiamare più gli include_once.
     */
    /*
		dirname(dirname(dirname(__FILE__))).'/dashboard/plugin' . PATH_SEPARATOR .
		dirname(dirname(dirname(__FILE__))).'/dashboard/themes' . PATH_SEPARATOR .
		dirname(dirname(dirname(__FILE__))).'/dashboard/js' . PATH_SEPARATOR .
    function my_autoloader($class) {
        include 'class/' . $class . '.php';
        echo "Loaded class/$class.php<br>";
    }
    
    spl_autoload_register('my_autoloader');
    
    
    function __autoload( $className ) {
        $className = str_replace( "..", "", $className );
        require_once( "class/$className.php" );
        echo "Loaded classes/$className.php<br>";
    }
    */
    
	require_once('Zend/Loader/StandardAutoloader.php');
    /*require_once 'Zend/Loader/ClassMapAutoloader.php';
    $loader = new Zend\Loader\ClassMapAutoloader( array(
                __DIR__ . '/autoload_classmap.php',
                'namespaces' => array(
                                    'Dashboard' => dirname(__DIR__) . '/class',
                                ),
            ));
			
'Library' => dirname(dirname(dirname(__FILE__))) .'/dashboard/Lib',
    */        
	$loader = new Zend\Loader\StandardAutoloader(
        array(            
            'namespaces' => array(
                                    'Dashboard' => dirname(__DIR__) . '/class',
                                    
                                ),
            'fallback_autoloader' => true,
            'autoregister_zf' => true
        )
    );
    
	$loader->register();
    
        
    //-----------------------------------------------------------------------------------------------//
    
    define("LOGO_IMG", 	      'logo.png');
    define("NOME_PRJ", 	      'DashBoard');
    define("DB_NAME", 	      'wolverine');
    define("PREFIX", 	      '');
    define("THEME", 	      'ares');
    define("THEME_FRONT",     'enfold');//'parallax');
    define("THEME_RULES", 	  'css');
    define("PROD", 	          false);
	/*********** VAR PATH ******************/
	define("ABSPATH",   		dirname(dirname(dirname(__FILE__))) . '/');
    define("DASHBOARD_PATH", 	'/dashboard/');
	/*
    define("DASHBOARD_PATH", 	dirname(dirname(__FILE__)).'/');
	define("CONFIG_PATH", 		dirname(dirname(__FILE__)).'/config/');
	define("INCLUDE_PATH", 		dirname(dirname(__FILE__)).'/include/');
	define("CHECK_PATH", 		dirname(dirname(__FILE__)).'/check/');
	define("CLASS_PATH", 		dirname(dirname(__FILE__)).'/class/');*/
	define("PLUGIN_CLASS_PATH", 'core/class/');
    define("PLUGIN_PATH", 		dirname(dirname(__FILE__)).'/plugin/');

    //define("ABSPATH",   		'/');
	define("JAVA_PATH", 		'/');
	define("JAVA_THEMES_PATH", 	DASHBOARD_PATH.'themes/');
	define("JAVA_PLUGIN_PATH", 	DASHBOARD_PATH.'plugin/');
    define("MEDIA_PATH", 		DASHBOARD_PATH.'media/');
    define("PLUGIN_MEDIA_PATH",	DASHBOARD_PATH.'plugin/');        

	//define("PAGE_NAME",			str_replace('-edit','',str_replace('.php','',basename($_SERVER['PHP_SELF']))));
    
    //define("PAGE_NAME",			strtoupper (str_replace('.php','',basename($_SERVER['PHP_SELF']))));
    
    $area_setting = array (
                            'LOG',
                            'PLUGIN',
                            'THEMES'
                          );
    //echo basename($_SERVER['PHP_SELF']);
    if(in_array( strtoupper (str_replace('_list','',str_replace('_edit','',str_replace('.php','',basename($_SERVER['PHP_SELF']))))), $area_setting) )
    {
        define("PAGE_NAME", "SETTINGS");
    }
    else
    {
        if((isset($_GET["plug"]) && $_GET["plug"] != '') || (isset($_GET["p_page"]) && $_GET["p_page"] != ''  ) )
        {
            define("PAGE_NAME", strtoupper ( str_replace('_list','',str_replace('_edit','',str_replace('.php','',( $_GET["plug"] )))) ) ) ;   
        }
        else
        {
            define("PAGE_NAME",			strtoupper (str_replace('_list','',str_replace('_edit','',str_replace('.php','',basename($_SERVER['PHP_SELF']))))));
        }
    }
    //echo 'page '.PAGE_NAME;
    //$_SESSION['MASTER'] = ( strpos(basename($_SERVER['PHP_SELF']), '_list') || strpos(basename($_SERVER['PHP_SELF']), '_edit') ) ? $_SESSION['MASTER'] : strtoupper (str_replace('.php','',basename($_SERVER['PHP_SELF']))); 
    //define("PAGE_NAME", $_SESSION['MASTER']);
    //echo PAGE_NAME;
    
    
    if((isset($_GET["plug"]) && $_GET["plug"] != '') || (isset($_GET["p_page"]) && $_GET["p_page"] != ''  ) )
    {
        define("PAGE_SUB", strtoupper ( str_replace('.php','',( $_GET["plug"].'_'.$_GET["p_page"] )) ) ) ;
        //define("PAGE_SUB",			( strpos(basename($_SERVER['PHP_SELF']), '_list') || strpos(basename($_SERVER['PHP_SELF']), '_edit') ) ? strtoupper (str_replace('.php','',basename($_SERVER['PHP_SELF']))) : NULL);   
        
    }
    else
    {
        //define("PAGE_SUB",			( strpos(basename($_SERVER['PHP_SELF']), '_list') || strpos(basename($_SERVER['PHP_SELF']), '_edit') ) ? strtoupper (str_replace('_list','',str_replace('_edit','',str_replace('.php','',basename($_SERVER['PHP_SELF']))))) : NULL);
	   define("PAGE_SUB",			( strpos(basename($_SERVER['PHP_SELF']), '_list') || strpos(basename($_SERVER['PHP_SELF']), '_edit') ) ? strtoupper (str_replace('.php','',basename($_SERVER['PHP_SELF']))) : NULL);
        //echo PAGE_SUB;
    }
    //echo 'sub '.PAGE_SUB;
	/***************************************/
	
	
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
    
    
    /*********** VAR GEN **************/
    define("ENABLE", 	'1');
    define("DISABLE", 	'0');
    
    /*********** DATE FORMAT **************/
    define("IT", 	  "d-m-Y H:i:s");
    define("IT_DATE", "d-m-Y");
    define("IT_DATE_SLASH", "d/m/Y");
    define("IT_EXT",  0);
    define("EN", 	  "Y-m-d H:i:s");
    define("EN_EXT",  1);
    
?>