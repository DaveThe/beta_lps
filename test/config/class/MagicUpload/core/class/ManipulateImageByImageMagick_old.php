<?php 
/**
 * La class ManipulateImageByImageMagick contiene le operazioni relative alla manipolazione di immagini con ImageMagick
 * 
 *
 * @version   1.00
 * @since     2015-06-17
 */
class ManipulateImageByImageMagick {
	
	public $depth          = '8';
	public $bordercolor    = 'white';
	public $border         = '0';
	public $quality        = '70';
	public $colorSpace     = 'RGB';	
	public $colorSpace1    = 'CMYK';
    public $profile        = 'CoatedFOGRA39.icc';
	public $profile2       = 'sRGB_IEC61966-2-1_no_black_scaling.icc';
	public $density        = '100';
	
	const IMAGE_GIF        = "gif";
	const IMAGE_JPEG       = "jpeg";
	const IMAGE_PNG        = "png";
	
	private $imgSource;
	private $widthImg;
	private $heightImg;
	private $allowedExtensions = 'jpg jpeg gif png';
	
    
	
	/**
	* Parametro contenente i dati extra dell'immagine caricata
    * 
	* @var Array
	*/
    public $exif_data 		        = NULL;

    
	/**
     * 
	 * Costruttore della classe
	 *
	 */
	public function __construct($src) 
    { //$src) {
		//$this->imgSource = $src;
        $this->imgSource  = $src;
	}

	/**
	 * Funzione che recupera l'estensione del file caricato
	 *
	 * @param String $imgExt estensione del file caricato
	 * @return boolean $ret esito controllo
	 *
	 */
	private function getImgType($imgExt) 
    {
		$returnImgType = false;
		
		$extensions = explode(" ", $this->allowedExtensions);
		
		for($i=0; count($extensions)>$i; $i=$i+1) 
        {
			if($extensions[$i]==$imgExt) 
            { 
				
				if($imgExt == "jpg" OR $imgExt=='jpeg')
					$returnImgType = self::IMAGE_JPEG;
				elseif ($imgExt == "gif")
					$returnImgType = self::IMAGE_GIF;
				elseif ($imgExt == 'png')
					$returnImgType = self::IMAGE_PNG;

				break; 
			}
		}
		
		return $returnImgType;
	}
	

	/**
	 * Funzione che si occupa del ridimensionamento delle immagini
	 *
	 * @param String $imgSource immagine caricata
	 * @param String $pathDestResize percorso di destinazione
	 * @param String $widthResize larghezza desiderata
	 * @param String $heightResize altezza desiderata
	 * @param String $imgType tipo immagine (non so se è utilizzata)
	 * @return boolean $ret esito ridimensionamento
	 *
	 */
	protected function resizeImageMagik($imgSource, $pathDestResize, $widthResize, $heightResize, $imgType) 
    {
		$result               = false;
		$orig_width_resize    = $widthResize;
		$orig_height_resize   = $heightResize;
		
		try 
        {
			
			if(!isset($widthResize) || trim($widthResize)=="")
			{
				$ratio			=	($this->widthImg/$this->heightImg);
				$widthResize	=	$heightResize * $ratio;
			}			
            
			$proportion_X = $this->widthImg / $widthResize;
			
			if(!isset($heightResize) || trim($heightResize)=="")
			{
				$ratio          =	 ($this->widthImg/$this->heightImg);
				$heightResize   =	$widthResize/$ratio;
			}
            
			$proportion_Y = $this->heightImg / $heightResize;
			
			if($proportion_X > $proportion_Y ) 
			{
				$proportion = $proportion_Y;

			}
			else 
			{
				$proportion = $proportion_X;

			}
			
			
			if((isset($orig_width_resize) && trim($orig_width_resize)!="") && (isset($orig_height_resize) && trim($orig_height_resize)!="") && $proportion<1)
			{
				var_dump($proportion);
				throw new Exception('L\'immagine inserita &egrave; troppo piccola.');
				
			}
			
			$target['width']             = $widthResize * $proportion;
			$target['height']            = $heightResize * $proportion;
			
			$original['diagonal_center'] = round(sqrt(($this->widthImg * $this->widthImg)+($this->heightImg * $this->heightImg))/2);
			$target['diagonal_center']   = round(sqrt(($target['width']*$target['width']) + ($target['height']*$target['height']))/2);
		
			$crop                        = round($original['diagonal_center'] - $target['diagonal_center']);

			if($proportion_X < $proportion_Y ) 
            {
				$target['x'] = 0;
				$target['y'] = round((($this->heightImg/2)*$crop)/$target['diagonal_center']);
			}
			else 
            {
				$target['x'] = round((($this->widthImg/2)*$crop)/$target['diagonal_center']);
				$target['y'] = 0;
			}
			if((isset($orig_width_resize) && trim($orig_width_resize)!="") && (isset($orig_height_resize) && trim($orig_height_resize)!=""))
			{ 
			
				if($proportion_X > $proportion_Y ) 
				{
					$proportion    = $proportion_Y;
					$resizeValue   = $widthResize.'<';
					$cropValue     =  '-gravity center -crop '.$widthResize.'x'.$heightResize.'+'.$target['x'].'+'.$target['y'].'';
				}
				else 
				{
					$proportion    = $proportion_X;
					$resizeValue   = 'x'.$heightResize.'<';
					$cropValue     = '-gravity center -crop '.$widthResize.'x'.$heightResize.'+'.$target['x'].'+'.$target['y'].'';
				}
			} 
			else if(isset($orig_width_resize) && trim($orig_width_resize)!="")
			{
				if($orig_width_resize > $this->widthImg)
				{
					$resizeValue = $widthResize.'<';
				}
				else
				{
					$resizeValue = $widthResize.'';
				}
                
				$cropValue =  '';
			}
			else
			{
				if($orig_height_resize > $this->heightImg)
				{
					$resizeValue = 'x'.$heightResize.'<';
				}
				else
				{
					$resizeValue = 'x'.$heightResize.'';
				}
                
                
				$cropValue =  '';
			}
			
            $extension_pos = strrpos($pathDestResize, '.'); // find position of the last dot, so where the extension starts
            $pathDestResizeb = substr($pathDestResize, 0, $extension_pos) . '_'.$widthResize.'X'.floor($heightResize) . substr($pathDestResize, $extension_pos);
            
			$conv    = ' -resize "'.$resizeValue.'" '.$cropValue.' "'.$pathDestResizeb.'"';
			$retstr  = exec(UploadFile::$MagikRoot.'convert -quality '.$this->quality.' "'.$imgSource.'" '.$conv, $output, $error);
			
			if($error==0)
            {	
			    //var_dump(UploadFile::$MagikRoot.'convert -quality '.$this->quality.' "'.$imgSource.'" '.$conv);
				$result = true;
			}
            else
            {
				$result = false;
			}
			
		}
		catch (Exception $e) 
        {
			 echo( json_encode(array('error' =>'Eccezione:'."<br>".$e->getMessage()."<br>")));
			 exit();
		}
		
		return $result;
	}

	

	/**
	 * Funzione che si occupa del ridimensionamento delle immagini
	 *
	 * @param String $imgSource immagine caricata
	 * @param String $pathDestResize percorso di destinazione
	 * @param String $widthResize larghezza desiderata
	 * @param String $heightResize altezza desiderata
	 * @param String $imgType tipo immagine (non so se è utilizzata)
	 * @return boolean $ret esito ridimensionamento
	 *
	 */
	public function manageImageMagik(  $imgSource,
                                       $ext, 
                                       $root_path, 
                                       $dest_path,
                                       $filename,
                                       $do_resize, 
                                       $widthResize, 
                                       $heightResize,
                                       $do_thumb, 
                                       $array_thumb
                                     ) 
    {

		$arResult         = array('result_resize' => false);
		
		$result           = false;
		
		$name             = explode(".", $imgSource);
		
		$localPath        = realpath('.');
				
		$imgType          = $this->getImgType(strtolower($ext));
		
		$pathDestResize   = $root_path."/".UploadFile::CleanDir($dest_path)."/".$filename;
		
		if(UploadFile::CheckDirSingle($pathDestResize))
		{
			return $arResult;
		}

		if($imgType && file_exists($imgSource)) 
        {
			$imgSource       = $imgSource;
			$size            = getimagesize($imgSource);
			$this->widthImg  = $size[0];
			$this->heightImg = $size[1];
			$imgWidth        = $this->widthImg;
			$imgHeight       = $this->heightImg;
			$res_thumb       = true;
			
            if($do_thumb)
            {			
    			foreach($array_thumb as $thumb)
    			{
    				if(UploadFile::CheckDirSingle($root_path."/".UploadFile::CleanDir($thumb['path'])))
    				{
    					//CREATE thumbnail if widthThumb or heightThumb exceded image size
    					if(( $thumb['width_thumb'] <= $imgWidth ||  $thumb['height_thumb'] <= $imgHeight)) 
    					{
    						$arResult['result_thumb_'.$thumb['name']] = $this->resizeImageMagik($imgSource, $root_path."/".UploadFile::CleanDir($thumb['path'])."/".$filename, $thumb['width_thumb'],  $thumb['height_thumb'], $imgType);
    						$res_thumb                                = $res_thumb && $arResult['result_thumb_'.$thumb['name']];
    					}
    					else
    					{
    						$arResult['result_thumb_'.$thumb['name']] = false;
    						$res_thumb                                = $res_thumb && $arResult['result_thumb_'.$thumb['name']];
    					}
    					
    				}
    				else
    				{
    					return $arResult;
    				}
    			}	
			}
			$arResult["result_thumb"] = $res_thumb;
			
			//RESIZE image if width or height exced
			if($do_resize && ($this->widthImg >= $widthResize || $this->heightImg >= $heightResize)) 
			{
				if($arResult['result_resize'] = $this->resizeImageMagik($imgSource, $pathDestResize, $widthResize, $heightResize, $imgType)) 
				{

				}
			}
			else
			{
				if(!$do_resize)
				{
					$arResult['result_resize']=true;
				}
				else
				{
					throw new Exception('L\'immagine inserita &egrave; troppo piccola.');
				}
			}
		}
		return  $arResult;
	}
    
        
    /**
     * Get the average pixel colour from the given file using Image Magick
     * 
     * @param bool $as_hex      Set to true, the function will return the 6 character HEX value of the colour.    
     *                          If false, an array will be returned with r, g, b components.
     */
    function get_average_colour($as_hex_string = true)
    {
        try 
        {
            // Read image file with Image Magick
            $image = new Imagick($this->imgSource);
            
            // Scale down to 1x1 pixel to make Imagick do the average
            $image->scaleimage(1, 1);
            
            /** @var ImagickPixel $pixel */
            if(!$pixels = $image->getimagehistogram()) {
                return null;
            }
        } 
        catch(ImagickException $e) 
        {
            echo 'get_average_colour: ';
            var_dump($e);
            // Image Magick Error!
            return null;
        } 
        catch(Exception $e) 
        {
            echo 'get_average_colour: ';
            var_dump($e);
            // Unknown Error!
            return null;
        }
        
        $pixel  = reset($pixels);
        $rgb    = $pixel->getcolor();
        
        if($as_hex_string) 
        {
            return sprintf('%02X%02X%02X', $rgb['r'], $rgb['g'], $rgb['b']);
        }
        
        return $rgb;
    }

    
        
    /**
     * Funzione che permette di inserire un watermark
     * 
     * @param string $filename immagine originale
     * @param bool $watermark_img immagine di watermark 
     * 
     */    
    function set_watermark($watermark_img)
    {
        try 
        {    		
            // Read image file with Image Magick
            $image          = new Imagick($this->imgSource);
            
            $watermark      = new Imagick($watermark_img);
            
            // how big are the images?
            $iWidth         = $image->getImageWidth();
            $iHeight        = $image->getImageHeight();
            $wWidth         = $watermark->getImageWidth();
            $wHeight        = $watermark->getImageHeight();
            
            if ($iHeight < $wHeight || $iWidth < $wWidth) 
            {
            // resize the watermark
            $watermark->scaleImage($iWidth, $iHeight);
            
            // get new size
            $wWidth         = $watermark->getImageWidth();
            $wHeight        = $watermark->getImageHeight();
            }
            
            // calculate the position
            $x              = ($iWidth - $wWidth) / 2;
            $y              = ($iHeight - $wHeight) / 2;
            
            $image->compositeImage($watermark, imagick::COMPOSITE_OVER, $x, $y);
        
        } 
        catch(ImagickException $e) 
        {
            var_dump($e);
            // Image Magick Error!
            return null;
        } 
        catch(Exception $e) 
        {
            echo '';
            var_dump($e);
            // Unknown Error!
            return null;
        }
        
        //header("Content-Type: image/" . $image->getImageFormat());
        return $image;
    }
    
    /**
     * Funzione che estrare tutte le informazioni allegate all'immagine
     * 
     * @param string $filename
	 * @return Array $exif array con tutto l'elenco di informazioni trovate
     */
    public function retrieve_exif_data() 
    {
        $exif_data = array();
        $exif_data['error'] = "0";
        try 
        {
			
            // Read image file with Image Magick
            $image = new Imagick($this->imgSource);
            //var_dump($image);
            // how big are the images?
            $exif = $image->getImageProperties();       
			//var_dump($exif); 
            foreach ($exif as $name => $property)
            {
                $name = str_replace("exif:", "", $name);
                if(strpos($name,'GPS') !== false)
                {
                    $subproperty = explode(",", $property);
                    if(sizeof($subproperty)>1)
                    {
                        foreach($subproperty as $prpty)
                        {
                            $exif_data[$name][] = $prpty;
                        }
                    }
                    else
                    {
                        $exif_data[$name] = $property;
                    }
                }
            }
        } 
        catch(ImagickException $e) 
        {
            //echo 'retrieve_exif_data: ';
            $exif_data['error']['ImagickException'] = $e;//"Errore in eccezione ImagickException";
            //var_dump($e);
            // Image Magick Error!
            return null;
        } 
        catch(Exception $e) 
        {
            //echo 'retrieve_exif_data: ';
            $exif_data['error']['General Exception'] = $e;//"Errore in eccezione Generica";
            //var_dump($e);
            // Unknown Error!
            return null;
        }
        
        $this->exif_data = $exif_data;
        
        return $exif_data;
    }
    
    
    public function getGPS(&$dLat, &$dLong) 
    {
        if(( (isset($this->exif_data) && $this->exif_data != '') && sizeof($this->exif_data)>1 ) && array_key_exists('GPSLatitude', $this->exif_data))
        {
            try
            {
                $latFirst  = (isset($this->exif_data['GPSLatitude'][0])) ? explode("/", $this->exif_data['GPSLatitude'][0]) : 0;
                $latSecond = (isset($this->exif_data['GPSLatitude'][1])) ? explode("/", $this->exif_data['GPSLatitude'][1]) : 0;
                $latThird  = (isset($this->exif_data['GPSLatitude'][2])) ? explode("/", $this->exif_data['GPSLatitude'][2]) : 0;
                $latRef    = isset($this->exif_data['GPSLatitudeRef']) ? $this->exif_data['GPSLatitudeRef'] : 'N';
                
                if($latFirst>0 && $latSecond>0 && $latThird>0)      
                {
                    $latFirst  = intval($latFirst[0]) / intval($latFirst[1]);
                    $latSecond = intval($latSecond[0])/ intval($latSecond[1]);
                    $latThird  = intval($latThird[0]) / intval($latThird[1]);
                    
                    $dLat = $latFirst + ($latSecond*60 + $latThird) / 3600;
                    
                    if ($latRef == 'S')
                        $dLat *= -1;
                    
                    $longFirst  = explode("/", $this->exif_data['GPSLongitude'][0]);
                    $longSecond = explode("/", $this->exif_data['GPSLongitude'][1]);
                    $longThird  = explode("/", $this->exif_data['GPSLongitude'][2]);
                    $longRef    = isset($this->exif_data['GPSLongitudeRef']) ? $this->exif_data['GPSLongitudeRef'] : 'E';
                    
                    $longFirst  = intval($longFirst[0]) / intval($longFirst[1]);
                    $longSecond = intval($longSecond[0])/ intval($longSecond[1]);
                    $longThird  = intval($longThird[0]) / intval($longThird[1]);
                    
                    $dLong = $longFirst + ($longSecond*60 + $longThird) / 3600;
                    
                    if ($longRef == 'W')
                        $dLat *= -1;
                }
            } 
            catch(Exception $e) 
            {
                $dLat   = 0;
                $dLong  = 0;
                //var_dump($e);
                // Unknown Error!
                //return null;
            }
        }
    
    }
}
?>