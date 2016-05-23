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
																	0=>array("name"=>"medium","width_thumb"=>100,"height_thumb"=>100,"path"=>"uploads/medium"),
																	1=>array("name"=>"small","width_thumb"=>50,"height_thumb"=>50,"path"=>"uploads/small")
																)
									)
				)
/*******************************************************/
$config_upload = 
array
(
	"NEWS"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/news/dett/",	
										"original_path"		=>	"media/news/dett/src/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"1200",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"NEWS_DETT"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/news/dett/",	
										"original_path"		=>	"media/news/dett/src/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"1200",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"ABOUT"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/about/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	false,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"600",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"CONTACT"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/contact/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	false,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"600",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"HOME"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/home/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	false,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"1200",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"AVATAR"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/avatar/",
										"original_path"		=>	"media/avatar/src/",			
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	false,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"600",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"IMAGE"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/image/",	
										"original_path"		=>	"media/image/src/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"600",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),/*
	"VIDEO"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"10",	
										"dest_path"			=>	"media/video/",	
										"type"				=>	"IMG",	
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,
										"do_rename"			=>	true,	
										"do_resize"			=>	true,	
										"width_resize"		=>	"640",	
										"height_resize"		=>	"",
										"do_thumb"			=>	true,
										"thumb_array"		=>	array()
									)
				),
	"SLIDER"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/slider/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"904",			
										"height_resize"		=>	"410",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"SLIDERMOB"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/slider/mobile/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"710",			
										"height_resize"		=>	"432",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"MAGAZINE"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/magazine/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"298",			
										"height_resize"		=>	"409",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"MAGAZINEDIAGO"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/magazine/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"90",			
										"height_resize"		=>	"60",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"ADV-SKIN"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/adv/skin/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"1920",			
										"height_resize"		=>	"1080",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"ADV-SPLASH"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/adv/skin/mobile/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"700",			
										"height_resize"		=>	"1100",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"ADV-BANNER-ORIZZONTALE-FILE1"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/adv/banner/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"908",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"ADV-BANNER-ORIZZONTALE-FILE2"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/adv/banner/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"908",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"ADV-BANNER-PICCOLO"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/adv/banner/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"600",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"ADV-NL-BANNER-LARGO"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/adv/newsletter/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"510",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				),
	"ADV-NL-BANNER-PICCOLO"	=>	array
				(	"opzioni"	=>	array
									(
										"max_file_size"		=>	"20",			
										"dest_path"			=>	"media/adv/newsletter/",		
										"type"				=>	"IMG",			
										"file_ext"			=> 	array(0 => "GIF",1 =>"PNG", 2=>"JPG"),
										"imgMagik"			=>	true,	
										"do_rename"			=>	true,			
										"do_resize"			=>	true,			
										"width_resize"		=>	"232",			
										"height_resize"		=>	"",
										"do_thumb"			=>	false,			
										"thumb_array"		=>	array()
									)
				)*/
				
);

$html_template = 
array(
	"IMG"	=>  "core/template/img.txt",				
	"FULL"	=>	"core/template/img.txt",
	"DND"	=>	"core/template/dnd.html"
    );
?>
