<?php
namespace Lapsic;
include_once(dirname(dirname(__FILE__)).'/config/config.php');

include_once('super.php');  

        ini_set('display_startup_errors',1);
        ini_set('display_errors',1);
        error_reporting(-1);
        
        
$ParametersList['pagination'] = true;
$ParametersList['elements_in_page'] = 1;
$mode = (isset($_GET['last_upd']) && $_GET['last_upd']) ? $_GET['last_upd'] : '';

$ParametersList['id_action'] = '9999';

$elements 			= LogAction::GetElementsList($ParametersList);
//echo $elements->current()->data_creation;
if($mode != '' && $mode != $elements->current()->data_creation)
{
    echo json_encode(array('esito'=>1,'data'=>$elements->current()->data_creation));
}
else
{
    echo json_encode(array('esito'=>0,'data'=>$elements->current()->data_creation));
}

?>