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

<!-- BOX CERCA  -->
<?php //include('include/box-cerca.php'); ?>
<!-- BOX CERCA  -->

<!-- BOX ADD PHOTO  -->
<?php //include('include/add-photo.php'); ?>
<!-- BOX ADD PHOTO  -->

<!-- BOX DETTAGLIO FOTO  -->
<?php //include('include/dettaglio-photo.php'); ?>
<!-- BOX DETTAGLIO FOTO  -->



<div class="container-all-page">

	<?php include ("include/header.php");?>
  
  <div class="content-profilo">
  <?php /*
  	<div class="box-profilo-top-edit">
      <div class="img-profilo-edit-photo">
        <img src="images/maschera-esagono.png" class="maschera-esagono" alt=""/>
        <img src="media/avatar/<?php echo ( ( (isset($lapsic_user->img) && $lapsic_user->img != '') ? $lapsic_user->img : 'avatar.png') ); ?>" width="100%" alt=""/>
      </div>
      <div class="name-profilo-edit-photo">
      	<?php echo ( ucfirst ( strtolower ( (isset($lapsic_user->nickname) && $lapsic_user->nickname != '') ? $lapsic_user->nickname : $lapsic_user->username ) ) ); ?>
      </div>
  	</div>
    */ ?>
    <div class="box-title-edit-photo">
    	<p>EDIT PHOTO</p>
    </div>
    <?php if(sizeof($array_photo) > 0) { ?>
        <?php foreach ($array_photo as $key => $el) {
            $dimensions = ElabImg('media/image/medium/',$el);
        ?>
            <div class="box-edit-photo" id="box_<?php echo( $key ); ?>">
            	<div class="box-txt-edit-photo">
                
                    <div id="data_<?php echo( $key ); ?>">
                        <input name="status" type="hidden" value="1" />
                        <input name="average_colour" type="hidden" value="<?php echo ($array_extra[$el]['extra_photo_average_colour']); ?>" />
                        <input name="extra_photo_lat" type="hidden" value="<?php echo ($array_extra[$el]['extra_photo_Lat']); ?>" />
                        <input name="extra_photo_lng" type="hidden" value="<?php echo ($array_extra[$el]['extra_photo_Lng']); ?>" />
                        <input name="photo_name" type="hidden" value="<?php echo ($el); ?>" />
                        <input name="photo_extra_info" type="hidden" value='<?php echo ($array_extra[$el]['extra_photo']); ?>' />
                        
                      	<button class="button-cyan-edit" id="data_<?php echo( $key ); ?>_title">
                        	inserisci un titolo >>
                        </button>
                        <textarea class="box-add-txt-photo-edit" name="name"></textarea>
                      	<button class="button-cyan-edit">
                        	scrivi una didascalia >>
                        </button>
                        <textarea class="box-add-txt-photo-edit" name="description" id="desc_<?php echo( $key ); ?>"></textarea>
                    </div>
                    <?php /*
                  	<button class="button-cyan-edit">
                    	inserisci gli hashtag >>
                    </button>
                    <textarea class="box-add-txt-photo-edit"></textarea>
                    
                    <div style="width: 24px; height:  24px; background-color: #<?php echo ($array_extra[$el]['extra_photo_average_colour']); ?>"></div>
                    <a target="_blank" href='https://maps.google.com/maps?q=<?php echo ($array_extra[$el]['extra_photo_Lat']. "," .$array_extra[$el]['extra_photo_Lng']); ?>'>Mappa</a>
                    */ ?>
                    <div class="box-cambia-elimina-photo">
                        <?php /*
                        <div class="box-single-azione-photo">
                            <img src="images/cambia-foto.jpg" width="100" height="40" alt=""/>
                        </div> 
                        */ ?>
                        <div class="box-single-azione-photo operations_new" style="cursor: pointer;" value="disabilita" ids="<?php echo( $key ); ?>">
                            <img src="images/status_foto.jpg" width="100" height="40" alt=""/>
                        </div> 
                        <div class="box-single-azione-photo txt-right operations_new" style="cursor: pointer;" value="elimina" ids="<?php echo( $key ); ?>" >
                            <img src="images/elimina-foto.jpg" width="100" height="40" alt=""/>
                        </div> 
                    </div>
                                        
                  	<button class="button-salva operations" value="save_img" id="save_<?php echo( $key ); ?>" ids="<?php echo( $key ); ?>">salva</button>
                </div>
                <div class="box-img-edit-photo">
                    <a class="single_2" href="media/image/<?php echo ($el); ?>" title="Lapsic.it">
                        <img src="<?php echo ($dimensions['name']); ?>" alt=""/>
                    </a>
                </div>
            </div>
        <?php } ?>        
    <?php } elseif($id != '') { 
            $dimensions = ElabImg('media/image/medium/',$element->source_name);?>
    <div class="box-edit-photo" id="box_<?php echo( $element->id ); ?>" <?php echo(($element->status == '0')?'style="opacity: 0.5;"':'') ?>>
    	<div class="box-txt-edit-photo">
        
            <div id="data_<?php echo( $element->id ); ?>">
                <input name="status" type="hidden" value="0" />
                <input name="average_colour" type="hidden" value="<?php echo ($element->average_colour); ?>" />
                <input name="extra_photo_lat" type="hidden" value="<?php echo ($element->lat); ?>" />
                <input name="extra_photo_lng" type="hidden" value="<?php echo ($element->lng); ?>" />
                <input name="photo_name" type="hidden" value="<?php echo ($element->source_name); ?>" />
                
              	<button class="button-cyan-edit" id="data_<?php echo( $element->id ); ?>_title">
                	inserisci un titolo >>
                </button>
                <textarea class="box-add-txt-photo-edit" name="name"><?php echo ($element->name); ?></textarea>
              	<button class="button-cyan-edit">
                	scrivi una didascalia >>
                </button>
                <textarea class="box-add-txt-photo-edit" name="description"><?php echo ($element->description); ?></textarea>
            </div>
            <?php /*
          	<button class="button-cyan-edit">
            	inserisci gli hashtag >>
            </button>
            <textarea class="box-add-txt-photo-edit"></textarea>
            
            <div style="width: 24px; height:  24px; background-color: #<?php echo ($array_extra[$el]['extra_photo_average_colour']); ?>"></div>
            <a target="_blank" href='https://maps.google.com/maps?q=<?php echo ($array_extra[$el]['extra_photo_Lat']. "," .$array_extra[$el]['extra_photo_Lng']); ?>'>Mappa</a>
            */ ?>
            <div class="box-cambia-elimina-photo">
                <?php /*
                <div class="box-single-azione-photo">
                    <img src="images/cambia-foto.jpg" width="100" height="40" alt=""/>
                </div> 
                */ ?>
                <div class="box-single-azione-photo operations" style="cursor: pointer;" value="abilita" ids="<?php echo( $element->id ); ?>">
                    <img src="images/status_foto<?php echo(($element->status == '0')?'_pubblica':''); ?>.jpg" width="100" height="40" alt=""/>
                </div> 
                <div class="box-single-azione-photo txt-right operations" style="cursor: pointer;" value="elimina" ids="<?php echo( $element->id ); ?>" >
                    <img src="images/elimina-foto.jpg" width="100" height="40" alt=""/>
                </div> 
            </div>
                                
          	<button class="button-salva operations" value="aggiorna" ids="<?php echo( $element->id ); ?>">aggiorna</button>
        </div>
        <div class="box-img-edit-photo">
            <a class="single_2" href="media/image/<?php echo ($element->source_name); ?>" title="<?php echo ($element->name); ?>">
                <img src="<?php echo ($dimensions['name']); ?>" alt=""/>
            </a>
        </div>
    </div>
    <?php } /* ?>  
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
