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

include_once(dirname(__FILE__).'/config/class/MagicUpload/index.php');
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | Add Photo</title>
<?php include_once('include/resources.php'); ?>

<script type="text/javascript" defer>

$(document).ready(function(e) {
    $('.button-salva-modifiche').click(function(){
    $(".button-salva-modifiche").mouseup(function() {

        $('.button-salva-modifiche').attr("disabled", true);	
        $('.text-msg').html("Form submiting.....");
    });
        
    });
	/*$('.button-chiudi').click(function(){
	console.log('chiudi');
	//parent.$.fancybox.close();
    try{
        parent.jQuery.fancybox.close();
    }catch(err){
        parent.$('#fancybox-overlay').hide();
        parent.$('#fancybox-wrap').hide();
    }
});*/
    
});



</script>
</head>
<body>
<div class="container-add-photo">
 <div class="content-add-photo">
 <?php /*
 	<div class="button-chiudi">
  	chiudi <span>x</span>
  </div>
  */
  ?>
  <div class="contenitore-box-add-photo pdBt28">
	<div class="txt-add-photo">
    	add your photos
    </div>
    <form target="_top" method="post" action="edit_photo.php" id="root_form">
		<input type="hidden" name="act" value="upload_img" />
        
        <div class="MKU_UPDND" id="upload"><input type="hidden" id="source_name" value="" /></div>
        
        <button type="submit" class="button-salva-modifiche" style="display:block; margin:auto;">Upload and edit</button>
    </form>  	
  </div>
 </div>
</div>

<?php
include_once(dirname(__FILE__).'/config/class/MagicUpload/script.php');
?>
</body>
</html>