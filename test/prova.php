<?php

        ini_set('display_startup_errors',1);
        ini_set('display_errors',1);
        error_reporting(-1);

    function ElabImg($img)
    {
        $width   = 0;
        $height  = 0;
        $name     = '';
        if (($pos = strpos($img, ".")) !== FALSE) {	
        	
        	$ext = substr($img, $pos+1); 
            //echo '<br>ext -'.$ext;
            
            $img_name = str_replace('.'.$ext,'', $img); 
            //echo '<br>img_name -'.$img_name;
            
            $new    = glob('media/image/medium/'.$img_name."*.".$ext);
            $new    = $new[0];
            $name   = $new;
            //echo '<br>new -'.$new;
            //print_r($new);
        	//echo $test;
        	
        	if (($pos = strpos($new, "_")) !== FALSE) {
        		
        		$test = str_replace('.'.$ext,'',substr($new, $pos+1)); 
        
        		//echo '<br>'.$test;
        		
        		if (($pos = strpos($test, "X")) !== FALSE) {
        		
        			$dim = explode("X", $test);
                    if(sizeof($dim)>0)
                    {
                        $width   = $dim[0];
                        $height  = $dim[1];
                    }
        		}
        	}
        }
        
        return array(
                        'name'      => $name,
                        'width'     => $width,
                        'height'    => $height,
                    );
    }
    
    
    
    $str = '50ae9d6ebcd68088c7a268181decccea.jpg';
    
    //var_dump(ElabImg($str));
    
    
    
    $mode = 3;
    
    if($mode == 1) $handle = opendir('media/image/medium/');
    if($mode == 2) $handle = opendir('media/image/small/');
    if($mode == 3) $handle = opendir('media/image/');
    while($file = readdir($handle))
    {
        if($file !== '.' && $file !== '..')
        {
            $ext = substr($file, strpos($file, ".")+1);
            $img_name = str_replace('.'.$ext,'', $file);
            //echo 'from- '.$file.' - a - '.$img_name.'_200X300'.'.'.$ext;
            
            if($mode == 1) list($width, $height, $type, $attr) = getimagesize('media/image/medium/'.$file);
            if($mode == 2) list($width, $height, $type, $attr) = getimagesize('media/image/small/'.$file);
            if($mode == 3) list($width, $height, $type, $attr) = getimagesize('media/image/'.$file);
            
            echo $width;
            echo '<br>';
            echo $height;
            echo '<br>';
            if($mode == 1) rename('media/image/medium/'.$file, 'media/image/medium/'.$img_name.'_'.$width.'X'.$height.'.'.$ext);
            if($mode == 2) rename('media/image/small/'.$file, 'media/image/small/'.$img_name.'_'.$width.'X'.$height.'.'.$ext);
            if($mode == 3) rename('media/image/'.$file, 'media/image/'.$img_name.'_'.$width.'X'.$height.'.'.$ext);
            
            echo 'fatto<br>';
            
            //echo '<img src="pictures/'.$file.'" border="0" />';
        }
    }
    
?>