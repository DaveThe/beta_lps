<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
include(dirname(dirname(dirname(__FILE__)))."/upload_config.php");
//echo dirname(dirname(dirname(__FILE__)))."/upload_config.php";
$section = isset($_GET['section']) ? strtoupper ( $_GET['section'] ) : NULL;

//try
//{
    if(isset($config_upload[$section]['opzioni']))
    {
  
        $return = array(
          "max_size" => $config_upload[$section]['opzioni']['max_file_size'],
          "fle_type" => $config_upload[$section]['opzioni']['type'],
          "err"      => ''
        );
        print json_encode($return);
    }
    else
    {
        $return = array(
                          "err" => 'Controllare la chiamata di Upload, probabile indice di sezione non corretto.'
                        );
        print json_encode($return);
        //throw new Exception('Controllare la chiamata di Upload, probabile indice di sezione non corretto.');
    }
/*
}
catch(Exception $e)
{
    $return = array(
          "err" => $e
        );
    print json_encode($return);
    //echo($e);	
    //exit();
} */     
/*** COSTANTI DI CONFIGURAZIONE ***/
//define("FILE_MAX_SIZE",$config_upload[$section]['opzioni']['max_file_size']);
//define("FILE_TYPE",$config_upload[$section]['opzioni']['type']);
/***/
?>