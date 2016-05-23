<?php 
namespace Dashboard;
$sec		= new Secret();
include_once(dirname(__FILE__).'/core/class/LapsicPhoto.php');
include_once(dirname(__FILE__).'/core/class/LapsicPhotoData.php');

//$querystring = 'plug=lapsic_user_manager&p_page=List.php';
$element = new LapsicPhoto($db);
$elements_extra = new LapsicPhotoData($db);
$element->CreateTable();

if(isset($id)) {
	
	if(!$element->GetElement($id)){
		header('Location: index.php?resp_code=615');
		exit ();
	}
    
    $ParametersList['id_photo']      = $id;
	$ParametersList['pagination']   = true;	
    if(!($elements_extra_data = $elements_extra->GetElementsListByPhoto($ParametersList) ) ){
		header('Location: index.php?resp_code=615');
		exit ();
	}
    $querystring = $querystring.'&id='.$id;    
}

if(isset($_POST["act"]) && $_POST["act"]=='tab_1') {
	$res = false;

	if(isset($_POST['avatar']) && trim($_POST['avatar'])!='')
    {
		$element->source_name     =  $_POST['avatar'];
        $element->source_path     = $_POST['avatar'];
	}
	else
	{	
		$errors[] = "Devi inserire un'immagine";
	}

	if(isset($_POST['name']) && trim($_POST['name'])!=''){
		$element->name 			=  $_POST['name'];
	}

	if(isset($_POST['description']) && trim($_POST['description'])!=''){
		$element->description 			=  $_POST['description'];
	}
    
	if(isset($_POST['extra_photo']) && trim($_POST['extra_photo'])!=''){
		$element->extra_photo 			=  $_POST['extra_photo'];
	}
	
	//var_dump(json_decode(str_replace("\\","",$_POST['extra_photo']), true));
    
    $arr_exif = json_decode(str_replace("\\","",$_POST['extra_photo']), true);
    
	if(isset($_POST['extra_photo_average_colour']) && trim($_POST['extra_photo_average_colour'])!=''){
		$element->average_colour		=  $_POST['extra_photo_average_colour'];
	}
    
	if(isset($_POST['extra_photo_Lat']) && trim($_POST['extra_photo_Lat'])!=''){
		$element->lat 			=  $_POST['extra_photo_Lat'];
	}
    
	if(isset($_POST['extra_photo_Lng']) && trim($_POST['extra_photo_Lng'])!=''){
		$element->lng 			=  $_POST['extra_photo_Lng'];
	}
    
	if(isset($_POST['extra_photo_width']) && trim($_POST['extra_photo_width'])!=''){
		$element->width 			=  $_POST['extra_photo_width'];
	}
    
	if(isset($_POST['extra_photo_height']) && trim($_POST['extra_photo_height'])!=''){
		$element->height 			=  $_POST['extra_photo_height'];
	}
    
    //echo $_POST['extra_photo_average_colour'];
    //echo $_POST['extra_photo_Lat'];
    //echo $_POST['extra_photo_Lng'];
    
    $element->created_by                   = $_SESSION['dashboard_iduser'];
    $element->id_owner                     = $_SESSION['dashboard_iduser'];
    
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
		
            $elements_extra->id_photo = $element->id;
            
            foreach($arr_exif as $name => $property)
            {
                if(sizeof($property)>1)
                {
                    foreach($property as $prpty)
                    {
                        $elements_extra->description = $name;
                        $elements_extra->value = $prpty;
                        
                        $res = $elements_extra->insert();
        		
            			if($res) {
            				$resp_code 			= 100;
                            
                            $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $elements_extra->id, ID_USER_LOG);                            
                            $ret		= $action->Insert();
            			} else {
            				$resp_code 			= 105;	
            			}
                    }
                } 
                else
                {
                    $elements_extra->description = $name;
                    $elements_extra->value = $property;
                    
                    $res = $elements_extra->insert();
    		
        			if($res) {
        				$resp_code 			= 100;
                        
                        $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $elements_extra->id, ID_USER_LOG);                            
                        $ret		= $action->Insert();
        			} else {
        				$resp_code 			= 105;	
        			}
                    
                }
        
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