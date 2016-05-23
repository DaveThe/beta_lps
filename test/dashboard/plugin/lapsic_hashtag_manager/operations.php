<?php 
namespace Dashboard;
$sec		= new Secret();
include_once(dirname(__FILE__).'/core/class/LapsicHashTag.php');
include_once(dirname(__FILE__).'/core/class/LapsicHashTagData.php');
include_once(dirname(__FILE__).'/core/class/LapsicHashTagGroup.php');

//$querystring = 'plug=lapsic_user_manager&p_page=List.php';
$element = new LapsicHashTag($db);
$elements_extra = new LapsicHashTagData($db);
$elements_group = new LapsicHashTagGroup($db);
$element->CreateTable();

$id_group = isset($_GET["id_group"]) && trim($_GET["id_group"]) != "" && is_numeric($_GET["id_group"]) 	? (int) $_GET["id_group"] : NULL;

if(isset($id_group) && $id_group != '') {
	
	if(!$elements_group->GetElement($id_group)){
		header('Location: index.php?resp_code=615');
		exit ();
	}    
    
    $querystring = $querystring.'&id='.$id;    
}
else
{
    if(isset($id)) {
    	
    	if(!$element->GetElement($id)){
    		header('Location: index.php?resp_code=615');
    		exit ();
    	}
        
        
        $ParametersList['id_user']      = $id;
    	$ParametersList['pagination']   = true;	
        if(!($groups = $elements_extra->GetElementsListGroup($ParametersList) ) )
        {
    		header('Location: index.php?resp_code=615');
    		exit ();
    	}
        
        
        $querystring = $querystring.'&id='.$id;    
    }
}

if(isset($_POST["act"]) && $_POST["act"]=='tab_1') {
	$res = false;

	if(isset($_POST['hashtag']) && trim($_POST['hashtag'])!=''){
		$hashtags 			=  $_POST['hashtag'];
	}
	
	$array_tags = $element->convertHashtags($hashtags);
    
    $element->tag_original = $hashtags;
        
    $element->created_by                   = $_SESSION['dashboard_iduser'];
    
    $element->ip_address = @Common::get_client_ip();
    
	if(sizeof($errors)==0) {
	   $ret = false;
		if( $id > 0 ){ //update
		
			$res = $element->Update();
			if($res) {
				$resp_code 			= 110;
                
                $action     = new LogAction($db, UPDATE, __FUNCTION__, __CLASS__, basename(__FILE__), $id, ID_USER_LOG);                            
                $ret		= $action->Insert();
				
			} else {
				$resp_code 			= 115;	
			}
	
		}else { //insert
        
            foreach($array_tags[1] as $tags)
            {
                $element->tag_name = $tags;
                $res = $element->insert();
                
                if($res === 'duplicate')
                {
                    $ret = true;
                    $resp_code = 100;
                }
                else
                {
        			if($res) {
        				$resp_code 			= 100;
                        
                        $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $element->id, ID_USER_LOG);                            
                        $ret		= $action->Insert();
        			} else {
        				$resp_code 			= 105;	
        			}
                }
            }
            /*
			if($res) {
				$resp_code 			= 100;
                
                $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $element->id, ID_USER_LOG);                            
                $ret		= $action->Insert();
			} else {
				$resp_code 			= 105;	
			}*/
		
		}

		if($ret) {
			header('Location: plugs.php?p_page='.$_page.'&plug='.$_plug.'&id='.$element->id.'&resp_code='.$resp_code);
			exit ();
		} else {
			$resp_code 				= 635;
		}
	}
}

if(isset($_POST["act"]) && $_POST["act"]=='tab_2') {
	$res = false;

	if(isset($_POST['value']) && trim($_POST['value'])!=''){
		$elements_group->value 			=  $_POST['value'];
	}
	else
	{	
		$errors[] 					= "Devi inserire una descrizione";
	}
	
	if(isset($_POST['description']) && trim($_POST['description'])!=''){
		$elements_group->description 			=  $_POST['description'];
	}
	else
	{	
		$errors[] 					= "Devi inserire una descrizione";
	}
	        
    $elements_group->created_by                   = $_SESSION['dashboard_iduser'];
    
    
	if(sizeof($errors)==0) {
	   $ret = false;
		if( $id > 0 ){ //update
		
			$res = $elements_group->Update();
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
        
            $res = $elements_group->insert();
            
			if($res) {
				$resp_code 			= 100;
                
                $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $elements_group->id, ID_USER_LOG);                            
                $ret		= $action->Insert();
			} else {
				$resp_code 			= 105;	
			}
            
			if($res) {
				$resp_code 			= 100;
                
                $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $elements_group->id, ID_USER_LOG);                            
                $ret		= $action->Insert();
			} else {
				$resp_code 			= 105;	
			}
		}

		if($ret) {
			header('Location: plugs.php?p_page='.$_page.'&plug='.$_plug.'&id='.$element->id.'&resp_code='.$resp_code);
			exit ();
		} else {
			$resp_code 				= 635;
		}
	}
}
include_once('operation_bar.php');
?>