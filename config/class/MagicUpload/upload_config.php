<?php 
/**************	ESEMPIO DI UTILIZZO ******************
	"NEWS"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"10",			//Dimensione massima upload
										"dest_path"			=>	"media/",		//Percorso di destinazione upload prinicpale
										"type"				=>	"IMG",			//Tipo di upload (IMG / FILE)
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG", 3=>"PDF"),	//Estensioni supportate
										"imgMagik"			=>	true,			// Se true utilizza imageMagik
										"do_rename"			=>	true,			//se true, rinomina il file
										"do_resize"			=>	true,			//se true, effettua il resize dell'immagine
										"width_resize"		=>	"640",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			//se true crea i thumbnail
										"thumb_array"		=>	array			//array con le specifiche dei thumbnail
																(	
																	0=>array("name"=>"medium","width_thumb"=>100,"height_thumb"=>100,"min_width"=>'',"min_height"=>'',"path"=>"uploads/medium"),
																	1=>array("name"=>"small","width_thumb"=>50,"height_thumb"=>50,"min_width"=>'',"min_height"=>'',"path"=>"uploads/small")
																),
                                        "optimization"      => true
									)
				)
/*******************************************************/
$config_upload = 
array
(
	"AVATAR"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/avatar/big/",
										"original_path"		=>	"media/avatar/src/",			
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG", 3=>"JPEG"),
										"imgMagik"			=>	true,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"78",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array(),
                                        "optimization"      => true
									)
				),
	"UPLOAD"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/image/big/",	
										"original_path"		=>	"media/image/src/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG", 3=>"JPEG"),
										"imgMagik"			=>	true,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"600",			
										"height_resize"		=>	"",
										"do_thumb"			=>	true,			
										"thumb_array"		=>	array(
                                                                    0=>array("name"=>"medium","width_thumb"=>200,"height_thumb"=>'',"min_width"=>'',"min_height"=>200,"path"=>"media/image/medium"),
                                                                    1=>array("name"=>"small","width_thumb"=>64,"height_thumb"=>30,"min_width"=>'',"min_height"=>'',"path"=>"media/image/small"),
                                                                    2=>array("name"=>"small_large","width_thumb"=>200,"height_thumb"=>50,"min_width"=>'',"min_height"=>'',"path"=>"media/image/small/large"),
                                                                ),
                                        "optimization"      => true
									)
				),				
);

$html_template = 
array(
	"IMG"	=>  "core/template/img.txt",				
	"FULL"	=>	"core/template/img.txt",
	"DND"	=>	"core/template/dnd.html"
    );
?>
