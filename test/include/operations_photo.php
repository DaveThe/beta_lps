<?php
namespace Lapsic;
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include_once(dirname(dirname(__FILE__)).'/config/config.php');

include_once('super.php');          
    
$element                   = new LapsicPhoto($db);
$elements_extra            = new LapsicPhotoData($db);
$element_hashtag           = new LapsicHashTag($db);

//echo dirname(dirname(dirname(__FILE__)))."/upload_config.php";
$section = isset($_POST["act"]) ? trim($_POST["act"]) : NULL;
$data = $_POST;

	if(isset($_POST['avatar']) && trim($_POST['avatar'])!='')
    {
		$element->source_name     =  $_POST['avatar'];
        $element->source_path     = $_POST['avatar'];
	}
	else
	{	
		$errors[] = "Devi inserire un'immagine";
	}

	if(isset($_POST['name']) && trim($_POST['name'])!='')
    {
		$element->name 			=  $_POST['name'];
	}
    
    $array_tags = array();
    
	if(isset($_POST['description']) && trim($_POST['description'])!=''){
		$element->description 			=  $_POST['description'];
        $hashtags 			            =  $_POST['description'];
	
    
        
    	$array_tags                             = $element_hashtag->convertHashtags($hashtags);
        
        $element_hashtag->tag_original          = $hashtags;
            
        $element_hashtag->created_by            = ID_USER_LOG;
        
        $element_hashtag->ip_address            = @Common::get_client_ip();
    }
    
    $arr_exif = array();
	if(isset($_POST['extra_photo']) && trim($_POST['extra_photo'])!='')
    {
		$element->extra_photo 			=  $_POST['extra_photo'];
        $arr_exif = json_decode(str_replace("\\","",$_POST['extra_photo']), true);
	}
	
	//var_dump(json_decode(str_replace("\\","",$_POST['extra_photo']), true));
    
    
	if(isset($_POST['extra_photo_average_colour']) && trim($_POST['extra_photo_average_colour'])!='')
    {
		$element->average_colour		=  $_POST['extra_photo_average_colour'];
	}
    
	if(isset($_POST['extra_photo_Lat']) && trim($_POST['extra_photo_Lat'])!='')
    {
		$element->lat 			=  $_POST['extra_photo_Lat'];
	}
    
	if(isset($_POST['extra_photo_Lng']) && trim($_POST['extra_photo_Lng'])!='')
    {
		$element->lng 			=  $_POST['extra_photo_Lng'];
	}
    
	if(isset($_POST['extra_photo_width']) && trim($_POST['extra_photo_width'])!='')
    {
		$element->width 			=  $_POST['extra_photo_width'];
	}
    
	if(isset($_POST['extra_photo_height']) && trim($_POST['extra_photo_height'])!='')
    {
		$element->height 			=  $_POST['extra_photo_height'];
	}
    
    if(isset($_POST['status']) && trim($_POST['status'])!='')
    {
		$element->status		=  $_POST['status'];
	}
    
    //$time_start = round(microtime(true) * 1000);
    //$plus_24    = 86400000;
    $date_formt = new   \DateTime('NOW');
    $date_formt->add(new  \DateInterval('P1D'));
        
    //$date_formt = Date('Y-m-d H:i:s:u', ( $time_start + $plus_24 ) );
    //$lapsic_photo->time_left                    = $date_formt->format('Y-m-d H:i:s');
        
    $element->time_left                    = $date_formt->format('Y-m-d H:i:s'); //$time_start + $plus_24;
    
    $element->created_by                   = $lapsic_user->id;
    $element->id_owner                     = $lapsic_user->id;
    
if($section == 'save_img')
{   
	if(sizeof($errors)==0) 
    {
    	$ret = false;
        
    	$res = $element->insert();
    
    	if($res) 
        {
    		$resp_code 			= 100;
            
            $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $element->id, ID_USER_LOG, 'Inserisco foto caricata dall\'utente #:'.ID_USER_LOG);                            
            $ret		= $action->Insert();
    	} 
        else
        {
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
    		
        			if($res) 
                    {
        				$resp_code 			= 100;
                        
                        $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $elements_extra->id, ID_USER_LOG, 'Inserisco informazione extra della foto #:'.$element->id);                            
                        $ret		= $action->Insert();
        			} 
                    else 
                    {
        				$resp_code 			= 105;	
        			}
                }
            } 
            else
            {
                $elements_extra->description = $name;
                $elements_extra->value = $property;
                
                $res = $elements_extra->insert();
    	
    			if($res) 
                {
    				$resp_code 			= 100;
                    
                    $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $elements_extra->id, ID_USER_LOG, 'Inserisco informazione extra della foto #:'.$element->id);                            
                    $ret		= $action->Insert();
    			} 
                else 
                {
    				$resp_code 			= 105;	
    			}
                
            }
    
        }
        
        
    //$res = false;
    if (sizeof($array_tags) > 0)
    {   
        $element_hashtag->type_record = 'LapsicPhoto';
        foreach($array_tags[1] as $tags)
        {
            $element_hashtag->tag_name = $tags;
            $res = $element_hashtag->insert();
            
            if($res === 'duplicate')
            {
                $ret = true;
                $resp_code = 100;
                
                $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $element_hashtag->id, ID_USER_LOG, 'Inserimento hashtag già presente: '.$tags);                            
                $ret		= $action->Insert();
            }
            else
            {
    			if($res) 
                {
    				$resp_code 			= 100;
                    
                    $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $element_hashtag->id, ID_USER_LOG, 'Inserimento hashtag: '.$tags);                            
                    $ret		= $action->Insert();
    			} 
                else 
                {
    				$resp_code 			= 105;	
    			}
            }
        }
    }
        if($ret) 
        {
    		echo ( json_encode( 'OK' ) );
    	} 
        else 
        {
    		echo ( json_encode( 'KO' ) );
    	}
    }
    //echo ( json_encode( $_POST ) );
    //echo ( json_encode( $errors ) );
    //echo ( json_encode( 'salva' ) );
}
elseif($section == 'elimina')
{
    //echo ( json_encode( $_POST ) );
    //echo ( json_encode( 'elimina' ) );
    
    if(isset($_POST['id_photo']) && trim($_POST['id_photo'])!='')
    {
		$id 			=  $_POST['id_photo'];
	}
    
    //if( LapsicPhoto::Delete($db, $id) )
    if( LapsicPhoto::ChangeStatus($db, 'lapsic_photo', $id, '2', 'id') )
    {
        echo ( json_encode( 'OK' ) );
        //echo ( json_encode( 'cambio stato immagine' ) );   
    }
    else
    {
        echo ( json_encode( 'KO' ) );
    }
}
elseif($section == 'abilita')
{
    
    if(isset($_POST['id_photo']) && trim($_POST['id_photo'])!='')
    {
		$id 			=  $_POST['id_photo'];
	}
    
    if( LapsicPhoto::ToggleStatus($db,'lapsic_photo', $id) )
    {
        echo ( json_encode( 'OK' ) );
        //echo ( json_encode( 'cambio stato immagine' ) );
    }
    else
    {
        echo ( json_encode( 'KO' ) );
    }
}
elseif($section == 'aggiorna')
{
    
    if(isset($_POST['id_photo']) && trim($_POST['id_photo'])!='')
    {
		$element->id 			=  $_POST['id_photo'];
	}
    
    if(isset($_POST['status']) && trim($_POST['status'])!='')
    {
		$element->status		=  $_POST['status'];
	}
    
    //echo ( json_encode( array ("el" => $element, "post" => $_POST) ) ); exit();
	if(sizeof($errors)==0) 
    {
    	$ret = false;
    	$res = $element->Update();
    	if($res) 
        {
    		$resp_code 			= 110;
            
            $action     = new LogAction($db, UPDATE, __FUNCTION__, __CLASS__, basename(__FILE__), $id, ID_USER_LOG, 'Aggiorno elementi della foto #: '.$id);                            
            $ret		= $action->Insert();
    		
    	} 
        else 
        {
    		$resp_code 			= 115;	
    	}
        
    
		$res = $element_hashtag->Update();
		if($res) {
			$resp_code 			= 110;
            
            $action     = new LogAction($db, UPDATE, __FUNCTION__, __CLASS__, basename(__FILE__), $id, ID_USER_LOG, 'Aggiorno hashtag della foto #: '.$id);                            
            $ret		= $action->Insert();
			
		} else {
			$resp_code 			= 115;	
		}
        if($ret) 
        {
    		echo ( json_encode( 'OK' ) );
    	} 
        else 
        {
    		echo ( json_encode( 'KO' ) );
    	}
    }
    //echo ( json_encode( $_POST ) );
}
else
{
    echo ( json_encode( 'qualcosa non va' ) );
}

//       print json_encode($return);
 
?>