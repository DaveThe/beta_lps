<?php
    namespace Lapsic;
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
//echo dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/config/config.php';
include_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/config/config.php');
define("ID_USER_LOG", 0);

include_once(ABSPATH.'include/db.php');
$db = DBConnect();

$array_names = include_once('names.php');

$rand_country = array_rand($array_names, 1);

//var_dump($rand_country);
//echo '<br>';
//var_dump($array_names[$rand_country]);
//htmlentities(
$rand_name = array_rand($array_names[$rand_country], 1);

//var_dump(htmlentities($array_names[$rand_country][$rand_name]));
$name = htmlentities($array_names[$rand_country][$rand_name]);
if( isset($name) && $name != '')
{
    $lapsic_user                    = new LapsicUser($db);           
    $lapsic_user->password          =  'Lapsic123';

    $lapsic_user->nickname 			=  $name;
    $lapsic_user->username 			=  $name;
          
	$lapsic_user->email 			=  'd.tresoldi@addictify.it';
    
    $lapsic_user->country           = $rand_country;
    $lapsic_user->img               = 'avatar.png';
    $lapsic_user->status            = '1';
    
    //GENDER 9 VUOL DIRE CHE è UN FALSO UTENTE
    $lapsic_user->gender            = '9';
    //$lapsic_user->timers            = '0';
    //$lapsic_user->timing            = '0';
    //$lapsic_user->time_left         = '0';
    $lapsic_user->created_by        = '0';
    
               
    $ParametersList = array(
                            'db_adapter'        => $db,
                            'elements_in_page'  => '20',
                            'page'              => '1',
                            'text'              => NULL,
                            'status'            => 1,
                            'type'              => NULL,
                            'own_element'       => NULL,
                            'pagination'        => false,
                            'name'              => $name
                            );
    $elements 			= LapsicUser::GetElementsList($ParametersList);
    $count = 0;
    foreach ($elements as $rowArray) 
    {
        if(isset($rowArray->username) && $rowArray->username!='')
        {
            $count++;
        }
        //var_dump($rowArray->username);
    }
    
    if($count>0)
    {
        echo 'utente esistente...cambiare nome';
    }
    else
    {
    	$res = $lapsic_user->insert();
        
    	if($res) 
        {    			             
            $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG, "Inserimento utente fittizio di nome: ".$name);                            
            $ret		= $action->Insert();
    	} 
        
    	if($ret) 
        {
    		echo 'utente inserito';
    	} 
        else 
        {
    		echo 'errore di inserimento';
    	}
     }	
}

?>