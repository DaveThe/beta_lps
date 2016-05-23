<?php 
namespace Dashboard;
$sec		= new Secret();
include_once(dirname(__FILE__).'/core/class/LapsicNotification.php');


//$querystring = 'plug=lapsic_user_manager&p_page=List.php';
$element = new LapsicNotification($db);

$element->CreateTable();

if(isset($id)) {
	
	if(!$element->GetElement($id)){
		header('Location: index.php?resp_code=615');
		exit ();
	}
        
    $querystring = $querystring.'&id='.$id;    
}

if(isset($_POST["act"]) && $_POST["act"]=='tab_1') {
	$res = false;

	if(isset($_POST['notify']) && trim($_POST['notify'])!=''){
		$notify 			=  $_POST['notify'];
	}
	    
    $element->icon          = 'alert';
    $element->text          = $notify;    
    $element->user_source   = 'Lapsic Staff'; 
    $element->id_user_dest  = 0;    
    $element->created_by                   = $_SESSION['dashboard_iduser'];
        
	if(sizeof($errors)==0) {
	   $ret = false;
		if( $id > 0 ){ //update
		
			$res = $element->UpdateNotify();
			if($res) {
				$resp_code 			= 110;
                
                $action     = new LogAction($db, UPDATE, __FUNCTION__, __CLASS__, basename(__FILE__), $id, ID_USER_LOG);                            
                $ret		= $action->Insert();
				
			} else {
				$resp_code 			= 115;	
			}
	
		}
        else 
        { //insert
        
            $res = $element->InsertNotify();
                    
			if($res) {
				$resp_code 			= 100;
                
                $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $element->id, ID_USER_LOG);                            
                $ret		= $action->Insert();
			} else {
				$resp_code 			= 105;	
			}
		
		}

		if($ret) {
			header('Location: plugs.php?p_page='.$_page.'&plug='.$_plug.'&resp_code='.$resp_code);
			exit ();
		} else {
			$resp_code 				= 635;
		}
	}
}
include_once('operation_bar.php');
?>