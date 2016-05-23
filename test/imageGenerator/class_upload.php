<?php
namespace Lapsic;
/**
 * Definisco le costanti di ritorno errore o successo
 *  
 */
define("UPLFILE_OK", 0);
define("UPLFILE_WRONG_MAX", 2);
define("UPLFILE_NOFILE", 101);
define("UPLFILE_UPLOAD_ERROR", 102);
define("UPLFILE_WRONG_SIZE", 103);
define("UPLFILE_WRONG_TYPE", 104);
define("UPLFILE_MOVE_ERROR", 105);
define("UPLFILE_FILE_EXIST", 106); 
define("UPLFILE_NODIR", 107);
define("MAX_FILE_SIZE_KO", 108);
define("NO_DEST_PATH", 109);

/**
 * Includo le classi di supporto
 * 
 */
//include_once('class/ManipulateImageByGD.php');
include_once('ManipulateImageByImageMagick.php');


/**
 * La class class_upload contiene le operazioni relative alla manipolazioni delle immagini caricate.
 * 
 *
 * @version   1.00
 * @since     2015-06-17
 */
class Uploadfile
{
	/*
		Variabili del costruttore:
			$max_file_size => Dimensione massima dell'upload
			$root_path => Path della root del sito 
			$dest_path => Path di destinazione del file principale
			$file_ext => array con le estensioni accettate (array(0=>"ext.",...)
	*/	
    /**
     * VARIABILI COSTRUTTORE CLASSE
     * 
     * /

	/**
	* Parametro che indica la dimensione massima dell'upload
	*
	* @var int
	*/
	private $max_file_size 	= 	NULL;
    
	/**
	* Parametro che indica il Path della root del sito
	*
	* @var int
	*/
	private $root_path 		=	NULL;
    
	/**
	* Parametro che indica il Path di destinazione del file principale
	*
	* @var int
	*/
	public	$dest_path		=	NULL;
    
	/**
	* Parametro che indica il Path di destinazione del file originale
	*
	* @var int
	*/
	public	$original_path		=	NULL;
    
	/**
	* Parametro che indica se utilizzare ImageMagik 
	*
	* @var boolean true uso imagemagik
	*/
	public $imgMagik		= 	NULL;
        
	/**
	* Parametro che indica il tipo di upload effettuato (FILE | IMG)
    * FILE => 	un file generico
    * IMG  =>	un file immagine
	*
	* @var string
	*/
	private	$type_file		=	"FILE";
    
	/**
	* Array con le estensioni accettate (array(0=>"ext.",...)
	*
	* @var string
	*/
	private $file_ext 		= 	array();	
	
	/**
	* Array contenente i parametri di specifica per le miniature
    * 
    * array(	
    *			0=>array("name"=>"medium","width_thumb"=>100,"height_thumb"=>100,"path"=>"uploads/medium"),
    *			1=>array("name"=>"small","width_thumb"=>50,"height_thumb"=>50,"path"=>"uploads/small")
    *		);
	*
	* @var int
	*/
	public 	$thumb_array	=	array(	
					0=>array("name"=>"medium","width_thumb"=>100,"height_thumb"=>100,"min_width"=>'',"min_height"=>'',"path"=>"uploads/medium"),
					1=>array("name"=>"small","width_thumb"=>50,"height_thumb"=>50,"min_width"=>'',"min_height"=>'',"path"=>"uploads/small")
				);
                
    
	
    
	/**
	* Parametri che non si sa che cazzo fanno...mai richiamati
	*
	* @var int
	*/
	public static $MagikRoot		=	NULL;
	public	$do_rename		=	true;	
	public	$do_resize		= 	true;    
	public	$width_resize	=	500;
	public	$height_resize	=	500;	
	public	$do_thumb		=	true;
	public	$array_result	=	array();	
	public	$optimization	=	false;
	
	
    	
	/**
	 * Costruttore della classe
	 *
	 * @param db_adapter $db Risorsa del database da utilizzare
	 *
	 */
	public function __construct($max_file_size, $root_path, $dest_path, $original_path, $file_ext = NULL, $type = "FILE", $imgMagik) 
	{
        /**
         * Controlli preliminari prima di analizzare l'immagine
         */
		if($max_file_size > self::GetMaxFileSize())
		{
			throw new Exception('Il limite massimo di upload, supera il limite impostato sul server.');
		}
		else if(!isset($root_path) || trim($root_path)=="")
		{
			throw new Exception('Non &egrave; stata impostata la directory di root.');
		}
		else if(!isset($dest_path) || trim($dest_path)=="")
		{
			throw new Exception('Non &egrave; stata impostata la directory di destinazione.');
		}
		else if(!isset($original_path) || trim($original_path)=="")
		{
			throw new Exception('Non &egrave; stata impostata la directory di destinazione.');
		}
		
        /**
         * Pulisco path di destinazione
         */
		self::CheckDir($root_path, $dest_path);
		
		$this->max_file_size 	= 	$max_file_size;
		$this->root_path 		= 	$root_path;
		$this->dest_path 		= 	$dest_path;
		$this->original_path 		= 	$original_path;
		$this->file_ext 		= 	$file_ext;
		$this->type_file		=	$type;
		
	}
	
	
	/**
	 * Funzione che recupera i valori limite di massimo
	 *
	 * @return int $upload_mb limite massimo in mb
	 *
	 */
	public function GetMaxFileSize()
	{
		$max_upload       = (int)(ini_get('upload_max_filesize'));
		$max_post         = (int)(ini_get('post_max_size'));
		$memory_limit     = (int)(ini_get('memory_limit'));
		$upload_mb        = min($max_upload, $max_post, $memory_limit);
        
		return $upload_mb;
	}
	
	/**
	 * Funzione che fa un controllo sulla cartella di destinazione
	 *
	 * @param String $root_path percorso del root
	 * @param String $dest_path percorso destinazione upload
	 * @return boolean $ret esito controllo percorso
	 *
	 */
	public function CheckDir($root_path,$dest_path)
	{
		$ret=false;
		if(is_dir($root_path."/".self::CleanDir($dest_path)))
		{
			if(is_writable($root_path."/".self::CleanDir($dest_path)))
			{
				$ret=true;
			}
			else
			{
				throw new Exception('La cartella di destinazione non &egrave; scrivibile.');
			}
		}
		else
		{
			throw new Exception('La cartella di destinazione : "'.$root_path."/".self::CleanDir($dest_path).'" non &egrave; presente.');
		}
		
		return $ret;
	}
	
	
	/**
	 * Funzione che fa un controllo sul path di destinazione
	 *
	 * @param String $path percorso destinazione upload
	 * @return boolean $ret esito controllo percorso
	 *
	 */
	public static function CheckDirSingle($path)
	{
		$ret=false;
		if(is_dir($path))
		{
			if(is_writable($path))
			{
				$ret=true;
			}
		}
		return $ret;
	}
	
	/**
	 * Funzione che pulisce il path di destinazione caricamento
	 *
	 * @param String $path percorso destinazione upload
	 * @return String $clean_path percorso destinazione upload ripulito
	 *
	 */
	public static function CleanDir($path)
	{
		
        $clean_path="";
        
		if(substr($path,0,1) =="\\" || substr($path,0,1) =="/")
		{
			$clean_path = substr($path,1);
		}
		else
		{
			$clean_path=$path;
		}
        
		if((substr($path,strlen($path)-1,1) =="\\" || substr($path,strlen($path)-1,1) =="/"))
		{
			$clean_path = substr($path,0,strlen($path));
		}
		else
		{
			$clean_path=$path;
		}
        
		return $clean_path;
	
    }
	
	
	/**
	 * Funzione che controlla l'estensione del file caricato
	 *
	 * @param String $extension estensione del file caricato
	 * @param String $file_mime_type estensoni accettate
	 * @return boolean $ret esito controllo
	 *
	 */
	public function CheckFileExt($extension, $file_mime_type)
	{
		$isFileTypeOK = false;
        
		if(sizeof($this->file_ext) > 0 && isset($extension))
		{
			if (in_array($extension, $this->file_ext)) 
			{
			$isFileTypeOK = true;
			}
		}
		else
		{
			if(isset($file_mime_type)) 
			{
				switch($file_mime_type) 
				{
					case 'text/plain'					: $isFileTypeOK=true; 	break;			
					case 'application/pdf'				: $isFileTypeOK=true; 	break;
					case 'application/octetstream'		: $isFileTypeOK=true; 	break;
					case 'application/zip'				: $isFileTypeOK=true; 	break;
					case 'application/msword'			: $isFileTypeOK=true; 	break;
					case 'image/png'					: $isFileTypeOK=true;	break;
					case 'image/jpeg'					: $isFileTypeOK=true;	break;
					case 'image/pjpeg'					: $isFileTypeOK=true;	break;
					case 'image/gif'					: $isFileTypeOK=true;	break;
					case 'audio/mpeg'					: $isFileTypeOK=true; 	break;
					case 'audio/mp3'					: $isFileTypeOK=true; 	break;
					case 'audio/x-mpeg'					: $isFileTypeOK=true; 	break;
					case 'audio/mpeg'					: $isFileTypeOK=true; 	break;
					case 'audio/x-mp3'					: $isFileTypeOK=true; 	break;
					case 'audio/x-mpeg3'				: $isFileTypeOK=true; 	break;
					case 'audio/x-mpg'					: $isFileTypeOK=true; 	break;
					case 'audio/x-mpegaudio'			: $isFileTypeOK=true; 	break;
					case 'video/mpeg'					: $isFileTypeOK=true; 	break;
					case 'video/x-mpeg'					: $isFileTypeOK=true; 	break;
					case 'video/mp4'					: $isFileTypeOK=true; 	break;
					case 'application/x-shockwave-flash': $isFileTypeOK=true; 	break;	
				}
			}
			else
			{
				switch(strtoupper($extension))
				{
					case 'PDF'	: $isFileTypeOK=true;	break;
					case 'ZIP'	: $isFileTypeOK=true; 	break;
					case 'DOC'	: $isFileTypeOK=true; 	break;
					case 'DOCX'	: $isFileTypeOK=true; 	break;
					case 'MP3'	: $isFileTypeOK=true; 	break;
					case 'JPG'	: $isFileTypeOK=true; 	break;
					case 'GIF'	: $isFileTypeOK=true; 	break;
					case 'PNG'	: $isFileTypeOK=true; 	break;
					case 'TXT'	: $isFileTypeOK=true; 	break;
					case 'MP4'	: $isFileTypeOK=true; 	break;
					case 'SWF'	: $isFileTypeOK=true; 	break;
				}
			}
		}
		
		return $isFileTypeOK;
	}

	
	/**
	 * Funzione che trasforma il codice di errore in testo
	 *
	 * @param String $code errore rilevato
	 * @return boolean $messaggio stringa errore rilevato
	 *
	 */
	public function ReadError($code)
	{
		$messaggio ="";
		switch($code)
		{
			case UPLFILE_OK 			: 	$messaggio	=""; break;
			case UPLFILE_WRONG_MAX		:	$messaggio	="Il file &egrave; troppo grande."; break;
			case UPLFILE_NOFILE 		: 	$messaggio	="Non &egrave; stato caricato nessun file."; break;
			case UPLFILE_UPLOAD_ERROR	:	$messaggio	="Errore durante il caricamento del file."; break;
			case UPLFILE_WRONG_SIZE 	: 	$messaggio	="Il file &egrave; troppo grande o nullo."; break;
			case UPLFILE_WRONG_TYPE		:	$messaggio	="Tipo di file non consentito."; break;
			case UPLFILE_MOVE_ERROR 	: 	$messaggio	="Impossibile spostare il file nella cartella di destinazione."; break;
			case UPLFILE_FILE_EXIST		:	$messaggio	="Esiste un file con lo stesso nome &egrave; presente nella cartella di destinazione."; break;
			case UPLFILE_NODIR 			: 	$messaggio	="Impossibile salvare il file, directory non presente."; break;
			case MAX_FILE_SIZE_KO		:	$messaggio	="Il limite massimo di upload, supera il limite impostato sul server."; break;
			case NO_DEST_PATH		 	: 	$messaggio	="Non &egrave; stata impostata la directory di destinazione."; break;

		}
		
		return $messaggio;
	}	

	
	/**
	 * Funzione che prende in carico le immagini e le analizza
	 *
	 * @param String $file file caricato
	 * @return json $arResult json con i risultati
	 *
	 */
	public function MakeUpload($file)
	{
		//Controllo che il file non sia vuoto
		if(empty($file))
		{
			return json_encode(array('error' => self::ReadError(UPLFILE_NOFILE)));
		}
		//Controllo che non abbia errori
		if(($file['error'][0] != UPLFILE_OK) && ($file['error'][0] != 0)) 
		{
			return json_encode(array('error' => $file['error'][0]));
		}
		//Controllo che sia stato completato l'upload
		if(!is_uploaded_file($file['tmp_name'][0])) 
		{
			return json_encode(array('error' => self::ReadError(UPLFILE_UPLOAD_ERROR)));
		}
		
		
		$IsMovedFILEOK    = false;
        $IsSRC_OK         = false;
		$file_info        = pathinfo($file['name'][0]);
		$fileName         = $file['name'][0];
		$filesize         = $file['size'][0];
		
		//Controllo se devo rinominare il file con nome casuale o lasciare lo stesso nome  e aggiungere una particella
		if ($this->do_rename)
		{
			$fileName = md5(microtime()) .'.'. $file_info['extension'];
		}
		else
		{
			$particella = $rand = substr(md5(microtime()),rand(0,26),2);
			$fileName = preg_replace("/\\.[^.\\s]{3,4}$/", "", $fileName).$particella.'.'.$file_info['extension'];
		}
		
		//Controllo che la dimensione del file sia corretta e stia nei limiti
		if($file['size'][0]>($this->max_file_size * 1024 * 1024) || $file['size'][0]==0) 
		{
			return json_encode(array('error' => self::ReadError(UPLFILE_WRONG_SIZE)));
		}
		
		//Controllo l'estensione del file
		if(!self::CheckFileExt(strtoupper($file_info['extension']), $file['type'][0]))
		{ 
			return json_encode(array('error' => self::ReadError(UPLFILE_WRONG_TYPE)));
		}
		
		//Determino il path di salvataggio
		if(isset($this->root_path) && isset($this->dest_path))
		{
			$upload_dir      = $this->root_path."/".self::CleanDir($this->dest_path);
			$upload_dir_src  = $this->root_path."/".self::CleanDir($this->original_path);
		}
		else 
		{
			$localPath           = realpath('.');
			$findPath            = '/';
			$upload_dir          = substr($localPath, 0, strpos($localPath, $findPath)) . $this->dest_path;
			$upload_dir_src      = substr($localPath, 0, strpos($localPath, $findPath)) . $this->original_path;
		}
		//echo $upload_dir;
		
		//Controllo se esiste il Path di salvataggio
		if(!self::CheckDirSingle($upload_dir))
		{
			return json_encode(array('error' => self::ReadError(UPLFILE_NODIR)));
		}
        
		//Controllo se esiste il Path di salvataggio sorgente
		if(!self::CheckDirSingle($upload_dir_src))
		{
			return json_encode(array('error' => self::ReadError(UPLFILE_NODIR)));
		}
		/*if(file_exists($upload_dir . $fileName)) 
			$fileName = $file_info['filename'] .'_'. time() .'.'. $file_info['extension'];*/
		
		if(move_uploaded_file($file['tmp_name'][0], $upload_dir . $fileName)) 
		{
			$IsMovedFILEOK = true;
		}
		else 
		{             
            
			if (rename($file['tmp_name'][0], $upload_dir . $fileName))
			{
				$IsMovedFILEOK = true;
			}
		}
		
        //Salvo una copia nella cartella degli originali
        if(copy($upload_dir . $fileName, $upload_dir_src . $fileName) )
        {
            $IsSRC_OK   = true;
        }
            
		$ext = '.'.$file_info['extension'];
		
		if($IsMovedFILEOK && $IsSRC_OK) 
		{
			if($this->type_file=='IMG') 
			{
			     //$exif_data      = NULL;
                 //$average_colour = NULL;
                 $dLat = 0; $dLong = 0;
            	/**
            	 * Controllo quale funzione utilizzare (ImageMagik o GD)
            	 *
            	 */
				if($this->imgMagik)
				{ 
				    //Elaborazione immagini con ImageMagik
					$mni = new ManipulateImageByImageMagick($upload_dir.$fileName);
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
                                                                    $this->thumb_array,
                                                                    $this->optimization
                                                                );
                                                        
                    $exif_data          = $mni->retrieve_exif_data(); //json_encode($mni->retrieve_exif_data());
                    $average_colour     = $mni->get_average_colour(true);
                    $gps_data           = $mni->getGPS($dLat, $dLong);
				}
				else
				{ 
				    //Elaborazione immagini con GD
					$mni = new ManipulateImageByGD();
					$arResultManImage = $mni->manageImage(
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
                                                         );
                    $exif_data      = NULL;
                    $average_colour = NULL;
                    $gps_data       = NULL;
				}
				
				
				$arResult = array('error' => UPLFILE_OK, 
													'filename'          => 'del/'.$fileName, 
													'image'             => $arResultManImage, 
													'filedir'           => $this->dest_path, 
												    'size'              => $file['size'][0],
													'filename_orig'     => $file['name'][0],
                                                    'exif_data'         => $exif_data,
                                                    'average_colour'    => $average_colour,
                                                    'Lat'               => $dLat,
                                                    'Lng'               => $dLong  
                                 );
			} 
			else 
			{
						
				$arResult = array('error' => UPLFILE_OK, 
													'filename'          => $fileName, 
													'image'             => "", 
													'filedir'           => $this->dest_path, 
													'size'              => $file['size'][0],
													'filename_orig'     => $file['name'][0]
                                 );
			} 
            rename($upload_dir.$fileName, $this->root_path."/".$this->dest_path.'/del/'.$fileName);
			return json_encode($arResult);

		}
		else
		{
			return json_encode(array('error' => self::ReadError(UPLFILE_MOVE_ERROR)));
		}

	}
}


?>