<?php 

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
include_once('MagicUpload/upload_config.php');
include_once('MagicUpload/core/class/ManipulateImageByImageMagick.php');
?>
<html><head><title>Simple Test for ImageMetadataParser</title></head><body>
<div class="MKU_DND" id="news_dett"><input type="hidden" id="img_big" value="<?php echo (isset($element->img_big) ? $element->img_big : ''); ?>"/></div>
</body></html>
<?php
$upload_dir = dirname(__FILE__);
$fileName   = "/test.jpg";
					$mni = new ManipulateImageByImageMagick($upload_dir.$fileName);
                    /*
					$arResultManImage   = $mni->manageImageMagik(
                                                                    $upload_dir.$fileName,
                                                                    $file_info['extension'],
                                                                    $this->root_path, 
                                                                    $this->dest_path,
                                                                    $fileName,	
                                                                    $this->do_resize, 
                                                                    $this->width_resize, 
                                                                    $this->height_resize,
                                                                    $this->do_thumb,
                                                                    $this->thumb_array
                                                                );*/
                                                        
                    $exif_data          = $mni->retrieve_exif_data();
                    $average_colour     = $mni->get_average_colour(true);
                    $srccc = $upload_dir.$fileName;
echo '----------------------------------------------------------------------------------------------------------<br />';
echo 'exif_data<br />';
var_dump($exif_data);
echo '<br />average_colour<br />';
var_dump($average_colour);

echo '<br />average_colour 2<br />';
var_dump (get_average_colour('test.jpg', false));
                    
echo '<br />----------------------------------------------------------------------------------------------------------<br />';


/**
 * Get the average pixel colour from the given file using Image Magick
 * 
 * @param string $filename
 * @param bool $as_hex      Set to true, the function will return the 6 character HEX value of the colour.    
 *                          If false, an array will be returned with r, g, b components.
 */
function get_average_colour($filename, $as_hex_string = true) {
  try {
    // Read image file with Image Magick
    $image = new Imagick($filename);
    // Scale down to 1x1 pixel to make Imagick do the average
    $image->scaleimage(1, 1);
    /** @var ImagickPixel $pixel */
    if(!$pixels = $image->getimagehistogram()) {
      return null;
    }
  } catch(ImagickException $e) {
    // Image Magick Error!
    return null;
  } catch(Exception $e) {
    // Unknown Error!
    return null;
  }

  $pixel = reset($pixels);
  $rgb = $pixel->getcolor();

  if($as_hex_string) {
    return sprintf('%02X%02X%02X', $rgb['r'], $rgb['g'], $rgb['b']);
  }

   return $rgb;
}



/**
 * Get an image and a size and make the resize
 * 
 * @param string $filename
 * @param string $width 
 * @param string $height   
 * @param bool $ratio      Set to true, the function will mantain the ratio of the image.    
 *                          If false, the funtionc is forced to ignore the aspect ratio.
 */
function image_resizer($filename, $width, $height, $ratio = true) {
  try {
    // Read image file with Image Magick
    $image = new Imagick($filename);
	
    // how big are the images?
	$iWidth = $image->getImageWidth();
	$iHeight = $image->getImageHeight();
	
	// resize the watermark
	$watermark->scaleImage($iWidth, $iHeight);
 
	// get new size
	$wWidth = $watermark->getImageWidth();
	$wHeight = $watermark->getImageHeight();
	
	
  } catch(ImagickException $e) {
    // Image Magick Error!
    return null;
  } catch(Exception $e) {
    // Unknown Error!
    return null;
  }

  $pixel = reset($pixels);
  $rgb = $pixel->getcolor();

  if($as_hex_string) {
    return sprintf('%02X%02X%02X', $rgb['r'], $rgb['g'], $rgb['b']);
  }

   return $rgb;
}

function set_watermark($filename, $watermark_img){
	try {
		
		// Read image file with Image Magick
		$image = new Imagick($filename);
		 
		$watermark = new Imagick($watermark_img);
		 
		// how big are the images?
		$iWidth = $image->getImageWidth();
		$iHeight = $image->getImageHeight();
		$wWidth = $watermark->getImageWidth();
		$wHeight = $watermark->getImageHeight();
		 
		if ($iHeight < $wHeight || $iWidth < $wWidth) {
			// resize the watermark
			$watermark->scaleImage($iWidth, $iHeight);
		 
			// get new size
			$wWidth = $watermark->getImageWidth();
			$wHeight = $watermark->getImageHeight();
		}
		 
		// calculate the position
		$x = ($iWidth - $wWidth) / 2;
		$y = ($iHeight - $wHeight) / 2;
		 
		$image->compositeImage($watermark, imagick::COMPOSITE_OVER, $x, $y);
		
	} catch(ImagickException $e) {
		// Image Magick Error!
		return null;
	} catch(Exception $e) {
		// Unknown Error!
		return null;
	}
   
	header("Content-Type: image/" . $image->getImageFormat());
	echo $image;
}

/**
 * Get extra info of image
 * 
 * @param string $filename
 */
function retrieve_exif_data($filename) {
  try {
    // Read image file with Image Magick
    $image = new Imagick($filename);
	
    // how big are the images?
	$exif = $image->getImageProperties();
	
	
  } catch(ImagickException $e) {
    // Image Magick Error!
    return null;
  } catch(Exception $e) {
    // Unknown Error!
    return null;
  }

   return $exif;
}

var_dump (get_average_colour('test.jpg', false));
var_dump (get_average_colour('logo.gif', true));

//var_dump ( json_encode(retrieve_exif_data('test.jpg')) );
/* Loop trough the EXIF properties */
$GPS = array();
foreach (retrieve_exif_data('test.jpg') as $name => $property)
{
    echo "{$name} => {$property}<br />\n"; 
    $name = str_replace("exif:", "", $name);
    if(strpos($name,'GPS') !== false)
    {
        $subproperty = explode(",", $property);
        if(sizeof($subproperty)>1)
        {
            foreach($subproperty as $prpty)
            {
                $GPS[$name][] = $prpty;
            }
        }
        else
        {
            $GPS[$name] = $property;
        }
    }
}
var_dump($GPS);

  function getGPS(&$dLat, &$dLong, $GPS) {
    $latFirst  = explode("/", $GPS['GPSLatitude'][0]);
    $latSecond = explode("/", $GPS['GPSLatitude'][1]);
    $latThird  = explode("/", $GPS['GPSLatitude'][2]);
    $latRef    = isset($GPS['GPSLatitudeRef']) ? $GPS['GPSLatitudeRef'] : 'N';
    
    var_dump ($latFirst); echo '<br />';
    var_dump ( $latSecond); echo '<br />';
    var_dump ( $latThird); echo '<br />';
    var_dump ( $latRef); echo '<br />';
    
    
    $latFirst  = intval($latFirst[0]) / intval($latFirst[1]);
    $latSecond = intval($latSecond[0])/ intval($latSecond[1]);
    $latThird  = intval($latThird[0]) / intval($latThird[1]);

    $dLat = $latFirst + ($latSecond*60 + $latThird) / 3600;
    if ($latRef == 'S')
      $dLat *= -1;

    $longFirst  = explode("/", $GPS['GPSLongitude'][0]);
    $longSecond = explode("/", $GPS['GPSLongitude'][1]);
    $longThird  = explode("/", $GPS['GPSLongitude'][2]);
    $longRef    = isset($GPS['GPSLongitudeRef']) ? $GPS['GPSLongitudeRef'] : 'E';

    $longFirst  = intval($longFirst[0]) / intval($longFirst[1]);
    $longSecond = intval($longSecond[0])/ intval($longSecond[1]);
    $longThird  = intval($longThird[0]) / intval($longThird[1]);

    $dLong = $longFirst + ($longSecond*60 + $longThird) / 3600;
    if ($longRef == 'W')
      $dLat *= -1;
      
  }
  
  $dLat = 0; $dLong = 0;
  getGPS($dLat, $dLong, $GPS);
    echo "AAAAAAAA approximate GPS position: " .
        "<a href='https://maps.google.com/maps?q=" . $dLat . "," . $dLong . "'>Lat: " . $dLat . " Long: " . $dLong . "</a>";
  
// Note: $image is an Imagick object, not a filename! See example use below.
function autoRotateImage($image) {
    $orientation = $image->getImageOrientation();

    switch($orientation) {
        case imagick::ORIENTATION_BOTTOMRIGHT: 
            $image->rotateimage("#000", 180); // rotate 180 degrees
            break;

        case imagick::ORIENTATION_RIGHTTOP:
            $image->rotateimage("#000", 90); // rotate 90 degrees CW
            break;

        case imagick::ORIENTATION_LEFTBOTTOM: 
            $image->rotateimage("#000", -90); // rotate 90 degrees CCW
            break;
    }

    // Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
    $image->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
}

/*

TEST EXIF

*/
/*
	include('ImageMetadataParser.php');
	echo '<br />
<br />
<br /> ROBA TEST
<br />
<br />
';
  echo "<html><head><title>Simple Test for ImageMetadataParser</title></head><body>\n";
  $imageparser = new ImageMetadataParser('test.jpg');
  if (!$imageparser->parseExif())
    echo "Parsing of EXIF failed<br />\n";
  if (!$imageparser->parseIPTC())
    echo "Parsing of IPTC failed<br />\n";
  if ($imageparser->hasTitle())
    echo "Image Title: " . $imageparser->getTitle() . "<br />\n";
  if ($imageparser->hasDateTime())
    echo "Image Taken At: " . date('r', $imageparser->getDateTime()) . "<br />\n";
  if ($imageparser->hasOrientation())
    if ($imageparser->getOrientation() === 0)
      echo "Image is oriented properly.<br />\n";
    else {
      echo "Image needs to be rotated with <code>imagerotate(image, " . $imageparser->getOrientation() . ", 0);</code><br />\n";
      echo "Raw orientation info is " . $imageparser->getRawOrientation() . "<br />\n";
    }
  if ($imageparser->hasThumbnail()) {
	  echo 'THUMBNAIL<br />';
    echo "<img src='data:" . 
        $imageparser->getThumbnailContentType() .
        ";base64," .
        base64_encode( $imageparser->getThumbnail() ) .
        "' /><br />\n";
  }
  if ($imageparser->hasGPS()) {
    $dLat = 0; $dLong = 0;
    $imageparser->getGPS($dLat, $dLong);
    echo "approximate GPS position: " .
        "<a href='https://maps.google.com/maps?q=" . $dLat . "," . $dLong . "'>Lat: " . $dLat . " Long: " . $dLong . "</a>";
  }
  
  echo "
<br />
<br />GPS VEDIAMO COME LO PRENDE: ";
var_dump($imageparser->getCoGPS());
echo "
<br />
<br />";
  echo "</body></html>";
  
 */ 
  
  
  
  
  
  /**
   * STO USANDO LE GD LIBRARY
   * 
   *   
   */
  function average($img) {
    $w = imagesx($img);
    $h = imagesy($img);
    $r = $g = $b = 0;
    for($y = 0; $y < $h; $y++) {
        for($x = 0; $x < $w; $x++) {
            $rgb = imagecolorat($img, $x, $y);
            $r += $rgb >> 16;
            $g += $rgb >> 8 & 255;
            $b += $rgb & 255;
        }
    }
    $pxls = $w * $h;
    $r = dechex(round($r / $pxls));
    $g = dechex(round($g / $pxls));
    $b = dechex(round($b / $pxls));
    if(strlen($r) < 2) {
        $r = 0 . $r;
    }
    if(strlen($g) < 2) {
        $g = 0 . $g;
    }
    if(strlen($b) < 2) {
        $b = 0 . $b;
    }
    return "#" . $r . $g . $b;
  }
  
  
	echo '<br />
<br />
<br /> ROBA GD
<br />
<br />
';

echo average('test.jpg');

?>

        <?php /* <script src="<?php echo('/MagicUpload/core/js/upload.js'); ?>" type="text/javascript"></script> */ ?>
        

<script type="text/javascript">

function openImg(img) {
	$.fancybox({
		'href'						: img,
		'padding'					: 0,
		'showCloseButton'			: true,
		'overlayColor'				: '#222',
		'type'						: 'image',
		'scrolling'					: 'no'
	});
}
var preview_list = '';

</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="<?php echo('/MagicUpload/core/js/template.js'); ?>"></script>
        <script src="<?php echo('/MagicUpload/core/js/lang.js'); ?>"></script>
        <script src="<?php echo('/MagicUpload/core/js/uploads.js'); ?>"></script>
        <link href="<?php echo('/MagicUpload/core/css/upload.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(document).ready(function(){ 
    $(document).MagicUpload({
                              Anchor                : "panel-body", //classe di ancoraggio per recuperare l'id di upload
                              drop                  : true, //abilita funzione drag and drop
                              dropZone              : 'drop-zone', //id zona drag drop
                              uploadForm            : 'js-upload-form', //id form upload
                              inputfiles            : 'js-upload-files', //id input file
                              dropZoneCss           : 'upload-drop-zone', //classe css per la zona del drag and drop
                              dropZoneCss_drop      : 'upload-drop-zone drop', //stile grafico per quando si passa un file sopra alla zona dd
                              dropZoneId_finish     : 'js-upload-finished', //id sezione elenco file già caricati
                              error_shake           : true, //error shake
                              errorCss              : 'error', //css errore
                              successCss            : 'good', //css successo
                              lang                  : 'EN', // lingua messaggi
                        	  list                  : true, // visualizzare lista file caricati
                              preview               : false, // visualizzare anteprima
                              previewImg            : '',  // immagine anteprima da visualizzare
                              multiUpload           : true,  //abilita l'upload di più immagini con un solo drag and drop
                              debug                 : true  //abilita i console log
                            });
});
</script>