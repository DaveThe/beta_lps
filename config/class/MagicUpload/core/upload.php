<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


include('class/class_upload.php');
include('../upload_config.php');

$section=(isset($_POST['section']) && trim($_POST['section'])!="")?strtoupper ($_POST['section']):NULL;
try 
{
    //var_dump($_POST);
    //var_dump($_FILES);
    /*$_FILES["files"] = array (
                                "name"=> "f95a0fc995b9763a1b3e985a2f687793.jpg",
                                "type"=>"image/jpeg",
                                "tmp_name"=>"/media/image",
                                "error"=> 0,
                                "size"=> 6130200
                              );*/
			if(isset($_FILES["files"]))
			{   
				if(isset($section))
				{
					if(isset($config_upload[$section]['opzioni']))
					{
						$opzioni      = $config_upload[$section]['opzioni'];
						
						$obj_upload   = new Uploadfile(
                                                        $opzioni['max_file_size'],                      // Dimensione massima accettata
                                                        dirname(dirname(dirname(dirname(dirname(__FILE__))))),   // root sito
                                                        $opzioni['dest_path'],                          // path di destinazione
                                                        $opzioni['original_path'],                      // path di destinazione originale
                                                        $opzioni['file_ext'],                           // estensioni file accettate
                                                        $opzioni['type'],                               // tipo di file consentito
                                                        $opzioni['imgMagik']                            // utilizzo di ImageMagik
                                                      );
                                                      
						$obj_upload->do_rename        = $opzioni['do_rename'];
						$obj_upload->do_resize        = $opzioni['do_resize'];
						$obj_upload->width_resize     = $opzioni['width_resize'];
						$obj_upload->height_resize    = $opzioni['height_resize'];
						$obj_upload->do_thumb         = $opzioni['do_thumb'];
						$obj_upload->thumb_array      = $opzioni['thumb_array'];
						$obj_upload->imgMagik         = $opzioni['imgMagik'];
                        
						if($obj_upload->imgMagik)
						{
							if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') 
							{
								UploadFile::$MagikRoot = 'C:/ImageMagick/';
							}
							else
							{
								UploadFile::$MagikRoot = '/usr/bin/';
							} 
							
							
							if(!file_exists(UploadFile::$MagikRoot))
							{
								echo(json_encode(array('error' =>'ImageMagik non &egrave; installato.')));
							}
							else
							{
								if($upload_dir=$obj_upload->MakeUpload($_FILES['files']))
								{
									echo($upload_dir);
								}
							}
							
						}
						else
						{
							if($upload_dir=$obj_upload->MakeUpload($_FILES['files']))
							{
								echo($upload_dir);
							}
						}
					}
					else
					{
						echo(json_encode(array('error' =>'Impossibile creare il form di upload, controllare il file di configurazione.')));
					}
				}
				else
				{
					echo(json_encode(array('error' =>'Impossibile identificare la tipologia di upload!<br>Area mancante.')));
				}
			}
            else
            {
                echo(json_encode(array('error' =>'nessun file passato!')));                
            }
} 
catch (Exception $e) 
{
    echo( json_encode(array('error' =>'Eccezione:'.$e->getMessage())));
}

?> 
