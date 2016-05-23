<?php
/**
 * La class ManipulateImageByGD contiene le operazioni relative alla manipolazione di immagini con le GD Library
 * 
 *
 * @version   1.00
 * @since     2015-06-17
 */
class ManipulateImageByGD {
    
    
	/**
	* Setto le costanti di appoggio
	*
	*/
	const IMAGE_GIF        = "gif";
	const IMAGE_JPEG       = "jpeg";
	const IMAGE_PNG        = "png";
	
	private $imgSource;
	private $widthImg;
	private $heightImg;
	private $allowedExtensions = 'jpg jpeg gif png';
	
	/**
	 * Costruttore della classe
	 *
	 */
	public function __construct() { //$src) {
		//$this->imgSource = $src;
	}

	/**
	 * Funzione che controlla l'estensione del file caricato
	 *
	 * @param String $imgExt estensione del file caricato
	 * @return boolean $ret esito controllo
	 *
	 */
	private function getImgType($imgExt) 
    {
		$returnImgType    = false;
		
		$extensions       = explode(" ", $this->allowedExtensions);
		
		for($i=0; count($extensions)>$i; $i=$i+1) 
        {
			if( $extensions[$i] == $imgExt ) { 
				
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
	
	//Esempio chiamata funzione
	//makeIcons_MergeCenter('temporaryUpload/logo_mm.gif', 'temporaryUpload/logo_mm2.gif', MAX_IMG_WIDTH_NEWS, MAX_IMG_HEIGHT_NEWS);
	protected function resizeImage($imgSource, $pathDestResize, $widthResize, $heightResize, $imgType) {
		$result = false;

		try {
			
			if(!isset($widthResize) || trim($widthResize)=="")
			{
				$ratio			=	($this->widthImg/$this->heightImg);
				$widthResize	=	$heightResize * $ratio;
			}			
			$proportion_X = $this->widthImg / $widthResize;
			
			if(!isset($heightResize) || trim($heightResize)=="")
			{
				$ratio	=	 ($this->widthImg/$this->heightImg);
				$heightResize	=	$widthResize/$ratio;
			}
			$proportion_Y = $this->heightImg / $heightResize;
			
			if($proportion_X > $proportion_Y ) 
				$proportion = $proportion_Y;
			else 
				$proportion = $proportion_X;
			
	
			$target['width'] = $widthResize * $proportion;
			$target['height'] = $heightResize * $proportion;
			
			$original['diagonal_center'] = round(sqrt(($this->widthImg * $this->widthImg)+($this->heightImg * $this->heightImg))/2);
			$target['diagonal_center'] = round(sqrt(($target['width']*$target['width']) + ($target['height']*$target['height']))/2);
		
			$crop = round($original['diagonal_center'] - $target['diagonal_center']);
		
			if($proportion_X < $proportion_Y ) {
				$target['x'] = 0;
				$target['y'] = round((($this->heightImg/2)*$crop)/$target['diagonal_center']);
			}
			else {
				$target['x'] =  round((($this->widthImg/2)*$crop)/$target['diagonal_center']);
				$target['y'] = 0;
			}

			if($imgType == self::IMAGE_JPEG)
				$imgObjOriginal = ImageCreateFromJpeg($imgSource); //$this->imgSource);
			elseif ($imgType == self::IMAGE_GIF)
				$imgObjOriginal = ImageCreateFromGIF($imgSource); //$this->imgSource);
			elseif ($imgType == self::IMAGE_PNG)
				$imgObjOriginal = imageCreateFromPNG($imgSource); //$this->imgSource);
		
			$imgObjResize = imagecreatetruecolor ($widthResize, $heightResize);
			$this->checkTransparentColor($imgObjResize, $imgObjOriginal, $widthResize, $heightResize);
				
			imagecopyresampled ($imgObjResize,  $imgObjOriginal,  0, 0, $target['x'], $target['y'], $widthResize, $heightResize, $target['width'], $target['height']);


			if($imgType == self::IMAGE_JPEG) {  // ($fileExtension == "jpg" || $fileExtension == 'jpeg') {
				imagejpeg($imgObjResize, $pathDestResize, 70);
			}
			elseif ($imgType == self::IMAGE_GIF) {  // ($fileExtension == "gif") {
				imagegif($imgObjResize, $pathDestResize);
			}
			elseif ($imgType == self::IMAGE_PNG) {  // ($fileExtension == 'png') {
				imagepng($imgObjResize, $pathDestResize);
			}
			
			$result = true;
			
		}
		catch (Exception $e) {
		}
		
		return $result;
	}

	
	protected function checkTransparentColor($newImage, $from, $dstWidth, $dstHeight) {
		
		//$newImage = imagecreatetruecolor ($dstWidth, $dstHeight);
		$originaltransparentcolor = imagecolortransparent($from);
		// for animated GIF, imagecolortransparent will return a color index larger
		// than total colors, in this case the image is treated as opaque ( actually
		// it is opaque
		if($originaltransparentcolor>=0 && $originaltransparentcolor<imagecolorstotal($from)) {
			$transparentcolor = imagecolorsforindex($from, $originaltransparentcolor);
			$newtransparentcolor = imagecolorallocate($newImage, $transparentcolor['red'], $transparentcolor['green'], $transparentcolor['blue']);
			// for true color image, we must fill the background manually
			imagefill($newImage, 0, 0, $newtransparentcolor );
			// assign the transparent color in the thumbnail image
			imagecolortransparent( $newImage, $newtransparentcolor );
		}	
		
	}
	
	protected function createThumbnail($thumbDest, $thumbWidth, $thumbHeight, $srcCropFrom, $imgWidth, $imgHeight, $imgType) {
		$thumbImage = imagecreatetruecolor ($thumbWidth, $thumbHeight);
		
		//$imgCropFrom = $imgType = $this->IMAGE_JPEG ? ImageCreateFromJpeg(srcCropFrom) : $imgType = $this->IMAGE_GIF ? ImageCreateFromGIF(srcCropFrom) : imageCreateFromPNG(srcCropFrom);
		
		if($imgType == self::IMAGE_JPEG) 
			$imgCropFrom = ImageCreateFromJpeg($srcCropFrom);
		elseif ($imgType == self::IMAGE_GIF)  
			$imgCropFrom = ImageCreateFromGIF($srcCropFrom);
		elseif ($imgType == self::IMAGE_PNG) 
			$imgCropFrom = imageCreateFromPNG($srcCropFrom);
		
		$this->checkTransparentColor($thumbImage, $imgCropFrom, $thumbWidth, $thumbHeight);
		
		/*if(isset($imgOriginal))	
			checkTransparentColor($thumbImage, $imgOriginal, $thumbWidth, $thumbHeight);
		else
			checkTransparentColor($thumbImage, $cropFrom, $thumbWidth, $thumbHeight);*/
		
	
		// cut out a rectangle from the resized image and store in thumbnail
		$newWidth = (($imgWidth / 2) - ($thumbWidth / 2));
		$newHeight = (($imgHeight / 2) - ($thumbHeight / 2));
	
		imagecopyresized($thumbImage, $imgCropFrom, 0, 0, $newWidth, $newHeight, $imgWidth, $imgHeight, $imgWidth, $imgHeight);
	
		if($imgType == self::IMAGE_JPEG)
			imagejpeg($thumbImage, $thumbDest, 70);
		elseif ($imgType == self::IMAGE_GIF)  
			imagegif($thumbImage, $thumbDest, 100);
		elseif ($imgType == self::IMAGE_PNG) 
			imagepng($thumbImage, $thumbDest);
		
	}


	//Esempio chiamata funzione
	//makeIcons_MergeCenter('temporaryUpload/logo_mm.gif', 'temporaryUpload/logo_mm2.gif', MAX_IMG_WIDTH_NEWS, MAX_IMG_HEIGHT_NEWS);
	public function manageImage($imgSource, $ext, $root_path, $dest_path,$filename,
															$do_resize, $widthResize, $heightResize, 
															$do_thumb, $array_thumb) {

		$arResult = array('result_resize' => false);
		
		$result = false;
		
		$name = explode(".", $imgSource);
		
		$localPath = realpath('.');
				
		$imgType = $this->getImgType(strtolower($ext));
		
		$pathDestResize = $root_path."/".UploadFile::CleanDir($dest_path)."/".$filename;
		
		if(UploadFile::CheckDirSingle($pathDestResize))
		{
			return $arResult;
		}

		if($imgType && file_exists($imgSource)) {
			$imgSource = $imgSource;
			$size = getimagesize($imgSource);
			$this->widthImg = $size[0];
			$this->heightImg = $size[1];
			$imgWidth = $this->widthImg;
			$imgHeight = $this->heightImg;
			$res_thumb=true;
						
			foreach($array_thumb as $thumb)
			{
				if(UploadFile::CheckDirSingle($root_path."/".UploadFile::CleanDir($thumb['path'])))
				{
					//CREATE thumbnail if widthThumb or heightThumb exceded image size
					if($do_thumb && ( $thumb['width_thumb'] <= $imgWidth ||  $thumb['height_thumb'] <= $imgHeight)) 
					{
						$arResult['result_thumb_'.$thumb['name']] = $this->resizeImage($imgSource, $root_path."/".UploadFile::CleanDir($thumb['path'])."/".$filename, $thumb['width_thumb'],  $thumb['height_thumb'], $imgType);
						$res_thumb=$res_thumb && $arResult['result_thumb_'.$thumb['name']];
					}
					else
					{
						$arResult['result_thumb_'.$thumb['name']] = false;
						$res_thumb=$res_thumb && $arResult['result_thumb_'.$thumb['name']];
					}
					
				}
				else
				{
					return $arResult;
				}
			}	
			
			$arResult["result_thumb"]=$res_thumb;
			
			//RESIZE image if width or height exced
			if($do_resize && ($this->widthImg > $widthResize || $this->heightImg > $heightResize)) 
			{
				if($arResult['result_resize'] = $this->resizeImage($imgSource, $pathDestResize, $widthResize, $heightResize, $imgType)) 
				{

				}
			}
			else
			{
				if(!$do_resize)
				{
					$arResult['result_resize']=true;
				}
			}
		}
		return  $arResult;
	}
	
}
?>
