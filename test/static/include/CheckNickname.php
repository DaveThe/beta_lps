<?php
namespace Lapsic;
include_once(dirname(dirname(__FILE__)).'/config/config.php');

include_once('super.php');  
$buggy = false;

if($buggy)
{
    ini_set('display_startup_errors',1);
    ini_set('display_errors',1);
    error_reporting(-1);
}    

$user           = new $lapsic_user($db);

$ParametersList['nickname'] = $_text;//'dqpFNCwIiu';
$ParametersList['text']     = '';
//echo $_text;

if(isset($ParametersList['nickname']) && $ParametersList['nickname'] != '')
{
    
    if($buggy) echo $ParametersList['nickname'].'<br>';
    if($buggy) echo '<br>';
    $results = LapsicUser::GetElementsList($ParametersList);    
    if($buggy) echo '<br>';
    $res = ( ($results) ? true : false );
    echo json_encode(array('esito'=>$res, 'count' => sizeof($results) ) );
}

?>