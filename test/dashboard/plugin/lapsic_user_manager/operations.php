<?php 
namespace Dashboard;
$sec		= new Secret();
include_once(dirname(__FILE__).'/core/class/LapsicUser.php');
include_once(dirname(__FILE__).'/core/class/LapsicUserData.php');

//$querystring = 'plug=lapsic_user_manager&p_page=List.php';
$element = new LapsicUser($db);
$elements_extra = new LapsicUserData($db);
$element->CreateTable();

$id_group = isset($_GET["id_group"]) && trim($_GET["id_group"]) != "" && is_numeric($_GET["id_group"]) 	? (int) $_GET["id_group"] : NULL;

if(isset($id_group) && $id_group != '') {
	
	if(!$elements_extra->GetElement($id_group)){
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
        if(!($elements_extra_data = $elements_extra->GetElementsListByUser($ParametersList) ) ){
    		header('Location: index.php?resp_code=615');
    		exit ();
    	}
        $querystring = $querystring.'&id='.$id;    
    }
}

if(isset($_POST["act"]) && $_POST["act"]=='tab_1') {
	$res = false;

	if(isset($_POST['username']) && trim($_POST['username'])!=''){
		$element->username =  $_POST['username'];
	}
	else
	{	
		$errors[] = "Devi inserire uno username";
	}

	if(isset($_POST['password']) && trim($_POST['password'])!='' && preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $_POST['password'])){
		if(isset($_POST['conferma_password']) && $_POST['password']==$_POST['conferma_password']){
			$element->password =  $_POST['password'];
		}else{
			$errors[] = "Le password non coincidono";
		}
	}
	else {
		$errors[] = "Devi inserire una password compresa tra gli 8 e i 20 caratteri, con una maiuscola e un numero";
	}

	if(isset($_POST['nickname']) && trim($_POST['nickname'])!=''){
		$element->nickname 			=  $_POST['nickname'];
	}
	
	if(isset($_POST['name']) && trim($_POST['name'])!=''){
		$element->name 			=  $_POST['name'];
	}
	
	if(isset($_POST['surname']) && trim($_POST['surname'])!=''){
		$element->surname 			=  $_POST['surname'];
	}

	if(isset($_POST['email']) && trim($_POST['email'])!='' && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
		$element->email 			=  $_POST['email'];
	}
	else
	{	
		$errors[] 					= "Devi inserire una Mail valida";
	}
    
    if(isset($_POST['gender']) && trim($_POST['gender']) != '')
    {
	   $element->gender 				    = $_POST['gender'];	
	}
	else
	{	
		$errors[] 					= "Devi dirmi se sei Uomo o Donna o altro";
	}

	if(isset($_POST['avatar']) && trim($_POST['avatar']) != '')
    {
	   $element->img 				    = $_POST['avatar'];	
	}
	else
	{	
        if($element->gender == 0 )
        {
            $element->img                = 'avatar5.png';
        }
        else if($element->gender == 1)
        {
            $element->img                = 'avatar3.png';
        }
        else
        {
            $element->img                = 'avatar2.png';
        }
		
	}
	
	if(isset($_POST['country']) && trim($_POST['country'])!=''){
		$element->country 					=  $_POST['country'];
	}
	
	if(isset($_POST['city']) && trim($_POST['city'])!=''){
		$element->city 					=  $_POST['city'];
	}
	
    $element->created_by                   = $_SESSION['dashboard_iduser'];
    
	if(sizeof($errors)==0) {
	
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
        
			$res = $element->insert();
		
			if($res) {
				$resp_code 			= 100;
                
                $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $element->id, ID_USER_LOG);                            
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

if(isset($_POST["act"]) && $_POST["act"]=='tab_2') {
	$res = false;

	if(isset($_POST['value']) && trim($_POST['value'])!=''){
		$elements_extra->value 			=  $_POST['value'];
	}
	else
	{	
		$errors[] 					= "Devi inserire una descrizione";
	}
	
	if(isset($_POST['description']) && trim($_POST['description'])!=''){
		$elements_extra->description 			=  $_POST['description'];
	}
	else
	{	
		$errors[] 					= "Devi inserire una descrizione";
	}
	        
    $elements_extra->created_by                   = $_SESSION['dashboard_iduser'];
    
    
	if(sizeof($errors)==0) {
	   $ret = false;
		if( $id > 0 ){ //update
		
			$res = $elements_extra->Update();
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
        
            $res = $elements_extra->insert();
            
			if($res) {
				$resp_code 			= 100;
                
                $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $elements_extra->id, ID_USER_LOG);                            
                $ret		= $action->Insert();
			} else {
				$resp_code 			= 105;	
			}
            
			if($res) {
				$resp_code 			= 100;
                
                $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $elements_extra->id, ID_USER_LOG);                            
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