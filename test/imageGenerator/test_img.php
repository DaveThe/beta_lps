<?php 
namespace Lapsic;

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Adapter\Adapter;

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
//echo (dirname(dirname(dirname(__FILE__))).'/upload_config.php');
//include_once(dirname(dirname(dirname(__FILE__))).'/upload_config.php');

include_once(dirname(dirname(__FILE__)).'/config/config.php');
include_once(dirname(dirname(__FILE__)).'/include/db.php');
include_once('class_upload.php');
include_once('ManipulateImageByImageMagick.php');
?>
<html><head><title>Simple Test for ImageMetadataParser</title></head><body>
<div class="MKU_UPDND" id="upload"><input type="hidden" id="source_name" value="" /></div>
</body></html>
<?php

$db = DBConnect();
$res = $db->query('SELECT source_path FROM lapsic_photo');

$results_lapsic_user = $res->execute();
        $results_lapsic_user->buffer();
        //var_dump($results_lapsic_user); //->current());
		//if ($results_lapsic_user->count() > 0) 
        $returnArray = array();
        // iterate through the rows
        foreach ($results_lapsic_user as $result) {
            $returnArray[] = $result;
        }
        //var_dump($returnArray);
$date = date("D M d, Y G:i");
echo 'PROCESSO INIZIATO - '.$date.'<br><br>';
foreach($returnArray as $retur)
{
    echo $retur['source_path'];

    $upload_dir = dirname(dirname(__FILE__)).'/media/image/src/';
    $fileName   = $retur['source_path'];//"/test.jpg";
    echo '<br>----'.$upload_dir.$fileName.' ---- <br>';
    					//$mni = new ManipulateImageByImageMagick($upload_dir.$fileName);
                        
    					
    		              $file_info        = pathinfo($fileName);
    				    //Elaborazione immagini con ImageMagik
    					$mni = new ManipulateImageByImageMagick($upload_dir.$fileName);
    					$arResultManImage   = $mni->manageImageMagik(
                                                                        $upload_dir.$fileName,
                                                                        $file_info['extension'],
                                                                        dirname(dirname(__FILE__)), 
                                                                        'media/image/big/',
                                                                        $fileName,	
                                                                        true, 
                                                                        '600', 
                                                                        '',
                                                                        true,
                                                                        array(
                                                                            0=>array("name"=>"medium","width_thumb"=>200,"height_thumb"=>'',"min_width"=>'',"min_height"=>200,"path"=>"media/image/medium"),
                                                                            1=>array("name"=>"small","width_thumb"=>64,"height_thumb"=>30,"min_width"=>'',"min_height"=>200,"path"=>"media/image/small"),
                                                                            2=>array("name"=>"small_large","width_thumb"=>200,"height_thumb"=>50,"min_width"=>'',"min_height"=>200,"path"=>"media/image/small/large"),
                                                                        ),
                                                                        true
                                                                    );
                                                            
                        //$exif_data          = $mni->retrieve_exif_data(); //json_encode($mni->retrieve_exif_data());
                        //$average_colour     = $mni->get_average_colour(true);
                        //$gps_data           = $mni->getGPS($dLat, $dLong);
                                                                                                                            
                        //$exif_data          = $mni->retrieve_exif_data();
                        //$average_colour     = $mni->get_average_colour(true);
                        $srccc = $upload_dir.$fileName;
                        
    echo '----------------------------------------------------------------------------------------------------------<br />';
    
    echo 'arResultManImage<br />';
    var_dump($arResultManImage);
    //echo 'exif_data<br />';
    //var_dump($exif_data);
    //echo '<br />average_colour<br />';
    //var_dump($average_colour);
    
    //echo '<br />average_colour 2<br />';
    //var_dump (get_average_colour('test.jpg', false));
                        
    echo '<br />----------------------------------------------------------------------------------------------------------<br />';
}
?>