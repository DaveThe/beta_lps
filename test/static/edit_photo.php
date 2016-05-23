<?php
namespace Lapsic;
/**
 * Pagina di Front-end del progetto Lapsic
 *
 *
 * @version   1.00
 * @since     2015-05-17
 * @company   http://addictify.it/
 */
/*
include_once(dirname(__FILE__).'/config/config.php');

include_once('super.php');  
//$sec		= new Lapsic\Secret();
//include_once(dirname(__FILE__).'/config/class/MagicUpload/index.php');
$array_photo = array();
$element = new LapsicPhoto($db);
if(isset($id)) 
{
	if(!$element->GetElement($id))
    {
		header('Location: index.php?resp_code=615');
		exit ();
	}	
}

if(isset($_POST["act"]) && $_POST["act"]=='upload_img') {
    //var_dump($_POST);
    $array_complete = $_POST["source_name"];
    
    foreach ($array_complete as $key => $value )
    {
        if(is_numeric($key))
        {
            $array_photo[]  = $value;
        }     
    }
    
    foreach ($array_complete as $key => $value )
    {
        if(!is_numeric($key))
        {
            $array_extra[str_replace("'", "", $key)]  = str_replace("'", "", $value);
        }     
    }
    //echo '<br><br><br>';
    //var_dump($array_extra); 
}
*/
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | #<?php echo ($lapsic_user->rank.' - '.$lapsic_user->nickname); ?>'s photo</title>
<?php include_once('include/resources.php'); ?>
<script type="text/javascript" src="js/editPhoto.js" defer></script>
<script type="text/javascript" defer>

</script>

</head>

<body>
<?php include('include/googanal.php'); ?>

<div class="container-all-page">

	<?php include ("include/header.php");?>
  
  <div class="content-profilo">

    <div class="box-title-edit-photo">
    	<p>EDIT PHOTO</p>
    </div>
    <?php if(sizeof($array_photo) > 0) { ?>
        <?php /* foreach ($array_photo as $key => $el) {
            $dimensions = ElabImg('media/image/medium/',$el);*/
        ?>
            <div class="box-edit-photo" id="box_12">
            	<div class="box-txt-edit-photo">
                
                    <div id="data_12">
                        <input name="status" type="hidden" value="1" />
                        <input name="average_colour" type="hidden" value="" />
                        <input name="extra_photo_lat" type="hidden" value="" />
                        <input name="extra_photo_lng" type="hidden" value="" />
                        <input name="photo_name" type="hidden" value="kdnsalkdnaslkd" />
                        <input name="photo_extra_info" type="hidden" value='' />
                        
                      	<button class="button-cyan-edit" id="data_12_title">
                        	inserisci un titolo >>
                        </button>
                        <textarea class="box-add-txt-photo-edit" name="name"></textarea>
                      	<button class="button-cyan-edit">
                        	scrivi una didascalia >>
                        </button>
                        <textarea class="box-add-txt-photo-edit" name="description" id="desc_12"></textarea>
                    </div>
                    
                    <div class="box-cambia-elimina-photo">
                        <?php /*
                        <div class="box-single-azione-photo">
                            <img src="images/cambia-foto.jpg" width="100" height="40" alt=""/>
                        </div> 
                        */ ?>
                        <div class="box-single-azione-photo operations_new" style="cursor: pointer;" value="disabilita" ids="12">
                            <img src="images/status_foto.jpg" width="100" height="40" alt=""/>
                        </div> 
                        <div class="box-single-azione-photo txt-right operations_new" style="cursor: pointer;" value="elimina" ids="12" >
                            <img src="images/elimina-foto.jpg" width="100" height="40" alt=""/>
                        </div> 
                    </div>
                                        
                  	<button class="button-salva operations" value="save_img" id="save_12" ids="12">salva</button>
                </div>
                <div class="box-img-edit-photo">
                    <a class="single_2" href="http://test.lapsic.it/media/image/d5e8ef9e308ed618430dc48aa7c8e2a3.jpg" title="Lapsic.it">
                        <img src="http://test.lapsic.it/media/image/medium/d5e8ef9e308ed618430dc48aa7c8e2a3_200X150.jpg" alt=""/>
                    </a>
                </div>
            </div>
        <?php } ?>        
    <?php /*} elseif($id != '') { 
            $dimensions = ElabImg('media/image/medium/',$element->source_name);*/?>
            <p>COMMENTO FITTIZIO PER FAR VEDERE CHE LA PARTE SOTTO APPARE QUANDO SI MODIFICA UNA FOTO ESISTENTE E HA POCHE COSE DIVERSE DA MANTENERE</p>
    <div class="box-edit-photo" id="box_13" >
    	<div class="box-txt-edit-photo">
        
            <div id="data_13">
                <input name="status" type="hidden" value="0" />
                
              	<button class="button-cyan-edit" id="data_12_title">
                	inserisci un titolo >>
                </button>
                <textarea class="box-add-txt-photo-edit" name="name"></textarea>
              	<button class="button-cyan-edit">
                	scrivi una didascalia >>
                </button>
                <textarea class="box-add-txt-photo-edit" name="description"></textarea>
            </div>
            <div class="box-cambia-elimina-photo">
                <div class="box-single-azione-photo operations" style="cursor: pointer;" value="abilita" ids="13">
                    <img src="images/status_foto_pubblica.jpg" width="100" height="40" alt=""/>
                </div> 
                <div class="box-single-azione-photo txt-right operations" style="cursor: pointer;" value="elimina" ids="13" >
                    <img src="images/elimina-foto.jpg" width="100" height="40" alt=""/>
                </div> 
            </div>
                                
          	<button class="button-salva operations" value="aggiorna" ids="13">aggiorna</button>
        </div>
        <div class="box-img-edit-photo">
            <a class="single_2" href="http://test.lapsic.it/media/image/d5e8ef9e308ed618430dc48aa7c8e2a3.jpg" title="Lapsic.it">
                <img src="http://test.lapsic.it/media/image/medium/d5e8ef9e308ed618430dc48aa7c8e2a3_200X150.jpg" alt=""/>
            </a>
        </div>
    </div>
    <?php //} /* ?>  
    <div class="box-edit-photo">
    	<div class="box-txt-edit-photo">
      	<button class="button-cyan-edit">
        	scrivi una didascalia >>
        </button>
        <textarea class="box-add-txt-photo-edit"></textarea>
      	<button class="button-cyan-edit">
        	inserisci gli hashtag >>
        </button>
        <textarea class="box-add-txt-photo-edit"></textarea>
        <div class="box-cambia-elimina-photo">
        	<div class="box-single-azione-photo">
          <img src="images/cambia-foto.jpg" width="100" height="40" alt=""/>
         </div>
        	<div class="box-single-azione-photo txt-right">
          <img src="images/elimina-foto.jpg" width="100" height="40" alt=""/>
         </div> 
        </div>
      	<button class="button-salva">salva</button>
      </div>
      <div class="box-img-edit-photo">
      	<img src="images/editable-photo.jpg" width="100%" alt=""/>
      </div>
    </div>
    <div class="box-edit-photo">
    	<div class="box-txt-edit-photo">
      	<button class="button-cyan-edit">
        	scrivi una didascalia >>
        </button>
        <textarea class="box-add-txt-photo-edit"></textarea>
      	<button class="button-cyan-edit">
        	inserisci gli hashtag >>
        </button>
        <textarea class="box-add-txt-photo-edit"></textarea>
        <div class="box-cambia-elimina-photo">
        	<div class="box-single-azione-photo">
          <img src="images/cambia-foto.jpg" width="100" height="40" alt=""/>
         </div>
        	<div class="box-single-azione-photo txt-right">
          <img src="images/elimina-foto.jpg" width="100" height="40" alt=""/>
         </div> 
        </div>
      	<button class="button-salva">salva</button>
      </div>
      <div class="box-img-edit-photo">
      	<img src="images/editable-photo2.jpg" width="100%" alt=""/>
      </div>
    </div>
    <?php */ ?>
  </div>
</div>


</body>
</html>
