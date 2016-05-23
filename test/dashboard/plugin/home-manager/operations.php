<?php 
namespace Dashboard;
include_once(dirname(__FILE__).'/core/class/HomeBlock.php');
//echo dirname(__FILE__).'/core/class/News.php';
//$querystring = 'plug=news-manager&p_page=List.php';
$element = new HomeBlock($db);
$element->CreateTable();
if(isset($id)) {
	
	if(!$element->GetElement($id)){
		header('Location: index.php?resp_code=615');
		exit ();
	}
		
}

if(isset($_POST["act"]) && $_POST["act"]=='save') 
{
	$res = false;
    
	if(isset($_POST['title']) && trim($_POST['title'])!='')
    {
		$element->title 			= $_POST['title'];
	}
	else
	{	
		$errors[] 						= "Devi inserire un titolo";
	}

	if(isset($_POST['subtitle']) && trim($_POST['subtitle'])!='')
    {
		$element->subtitle 			=  $_POST['subtitle'];
	}
	
	if(isset($_POST['abstract']) && trim($_POST['abstract'])!='')
    {
		$element->abstract 			=  $_POST['abstract'];
	}
	else
	{	
		$errors[] 						= "Devi inserire un testo corto";
	}
	
	if(isset($_POST['text']) && trim($_POST['text'])!='')
    {
		$element->text 					=  $_POST['text'];
	}
	else
	{	
		$errors[] 						= "Devi inserire un testo";
	}
	
	if(isset($_POST['date_begin']) && trim($_POST['date_begin'])!='')
    {
		$element->date_begin 					=  $_POST['date_begin'];
	}
	else
	{	
		$errors[] 						= "Devi inserire una data di inizio";
	}
	
	if(isset($_POST['date_end']) && trim($_POST['date_end'])!='')
    {
		$element->date_end 					=  $_POST['date_end'];
	}
    /*
	else
	{	
		$errors[] 						= "Devi inserire una data di fine";
	}
    */
	
	if(isset($_POST['img_small']) && trim($_POST['img_small'])!='')
    {
		$element->img_small 					=  $_POST['img_small'];
	} 
    	
	if(isset($_POST['img_big']) && trim($_POST['img_big'])!='')
    {
		$element->img_big 					=  $_POST['img_big'];
	}   
    
    $element->created_by                   = ID_USER_LOG;//$_SESSION['dashboard_iduser'];
	if(sizeof($errors)==0) {
        $ret = false;
		if( $id > 0 ){ //update
		
			$res = $element->Update();
			if($res) {
				$resp_code 			= 110;
                
                $action     = new LogAction($db, UPDATE, __FUNCTION__, __CLASS__, basename(__FILE__), $id, $element->created_by);                            
                $ret		= $action->Insert();
				
			} else {
				$resp_code 			= 115;	
			}
	
		}else { //insert
        
			$res = $element->insert();
		
			if($res) {
				$resp_code 			= 100;
                
                $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $element->id, $element->created_by);                            
                $ret		= $action->Insert();
			} else {
				$resp_code 			= 105;	
			}
		
		}

		if($ret) {
			header('Location: plugs.php?plug=home-manager&p_page=Edit.php&id='.$element->id.'&resp_code='.$resp_code);
			exit ();
		} else {
			$resp_code 				= 635;
		}
	}
}
include_once('operation_bar.php');
?>