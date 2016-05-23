<?php
    namespace Lapsic;
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

include_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/config/config.php');
include_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/config/class/MagicUpload/upload_config.php');
include_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/config/class/MagicUpload/core/class/ManipulateImageByImageMagick.php');
define("ID_USER_LOG", 0);

include_once(ABSPATH.'include/db.php');
$db = DBConnect();

$id = rand(3, 200);
$n  = rand(1,8);
echo $id.'<br>';
echo $n;

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if( isset($id) && $id != '')
{
    $lapsic_user                    = new LapsicUser($db);           
    $lapsic_photo                   = new LapsicPhoto($db);
    $element_hashtag                = new LapsicHashTag($db);
    
    if(!$lapsic_user->GetElement($id))
    {
		echo 'boooom errore';
        
		header('Location: ghost_users.php');
		exit ();
	}
    else
    {
             
                                
        $elements 			= $lapsic_photo->GetElementCount($id);
        
        var_dump($elements);
        if($elements>=3)
        {
            echo 'limite raggiunto quindi mi fermo';
        }
        else
        {
            /**
              * Simple function to replicate PHP 5 behaviour
              */
            function microtime_float()
            {
                 list($usec, $sec) = explode(" ", microtime());
                 return ((float)$usec + (float)$sec);
            }
            
            $time_start = round(microtime(true) * 1000);//microtime_float();
            $plus_24    = 86400000;
    
            $upload_dir = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/images/isotope/';
            $fileName   = '00'.$n.'.jpeg';
            
            $mni = new \ManipulateImageByImageMagick($upload_dir.$fileName);
        	$lapsic_photo->source_name     = $fileName;
            $lapsic_photo->source_path     = $fileName;
        
        	$lapsic_photo->name 			=  'test '.$n;
        
      		$lapsic_photo->description 			=  'foto test '.$n.' #'.generateRandomString().' - #'.generateRandomString();
            
            $hashtags 			            =  $lapsic_photo->description;   
            
        	$array_tags                             = $element_hashtag->convertHashtags($hashtags);
            
            $element_hashtag->tag_original          = $hashtags;
                
            $element_hashtag->created_by            = ID_USER_LOG;
            
            $element_hashtag->ip_address            = @Common::get_client_ip();     
              
            $arr_exif = array( 
                            	"GPSAltitude" => "0/1000",
                            	"GPSAltitudeRef"=> "0",
                            	"GPSDateStamp"=>  "2015:06:07", 
                            	"GPSImgDirection" => "95/1",
                            	"GPSImgDirectionRef"=>  "M",
                            	"GPSInfo"=>  "422",
                            	"GPSLatitude"=> array ( "45/1", "27/1", "447171/10000" ),
                            	"GPSLatitudeRef"=>  "N",
                            	"GPSLongitude"=> array( "8/1", " 37/1", "179287/10000" ),
                            	"GPSLongitudeRef"=>  "E",
                            	"GPSProcessingMethod"=>  "ASCII",
                            	"GPSTimeStamp"=> array( "16/1", "42/1", "32/1" )
                            );
            
        	$lapsic_photo->average_colour	=   $mni->get_average_colour(true);
        	
        	$lapsic_photo->lat 			    =  '45.4624214167';
            
        	$lapsic_photo->lng 			    =  '8.62164686111';
            
            $size            = getimagesize($upload_dir.$fileName);
    		//$this->widthImg  = $size[0];
    		//$this->heightImg = $size[1];
                
    		$lapsic_photo->width 			    =  '200';
    		$lapsic_photo->height 			    =  $size[1];
        	
            
            $lapsic_photo->created_by                   = '0';
            $lapsic_photo->id_owner                     = $id;
                    
            //$date_formt = new \DateTime(time().'+ 1 day');
            $date_formt = new   \DateTime('NOW');
            $date_formt->add(new  \DateInterval('P1D'));
                
            //$date_formt = Date('Y-m-d H:i:s:u', ( $time_start + $plus_24 ) );
            echo '<br>'.$date_formt->format('Y-m-d H:i:s:u').'<br>';
            $lapsic_photo->time_left                    = $date_formt->format('Y-m-d H:i:s');
            $lapsic_photo->status                       = '1';
    		$res = $lapsic_photo->Insert();
            
            if($res) 
            {    			             
                $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG, "Inserimento immagine da utente fittizio");                            
                $ret		= $action->Insert();
        	} 
            
            
                
            //$res = false;
            if (sizeof($array_tags) > 0)
            {   
                $element_hashtag->type_record   = 'LapsicPhoto';
                $element_hashtag->id_record     = $lapsic_photo->id;
                foreach($array_tags[1] as $tags)
                {
                    $element_hashtag->tag_name = $tags;
                    $res = $element_hashtag->insert();
                    echo $tags.'<br>';
                    if($res === 'duplicate')
                    {
                        $ret = true;
                        $resp_code = 100;
                        
                        $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $element_hashtag->id, ID_USER_LOG, 'Inserimento hashtag già presente: '.$tags);                            
                        $ret		= $action->Insert();
                    }
                    else
                    {
            			if($res) {
            				$resp_code 			= 100;
                            
                            $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $element_hashtag->id, ID_USER_LOG, 'Inserimento hashtag: '.$tags);                            
                            $ret		= $action->Insert();
            			} else {
            				$resp_code 			= 105;	
            			}
                    }
                }
            }
            
        	if($ret) 
            {
        		echo 'immagine inserito';
                echo '<br>'.$lapsic_photo->id;
        	} 
            else 
            {
        		echo 'errore di inserimento';
        	}
        }
        /*
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
         */	
    }
}

?>