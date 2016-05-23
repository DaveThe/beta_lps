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
//include_once('check_login.php');
$ParametersList['pagination'] = true;
$ParametersList['elements_in_page'] = 10;
$ParametersList['order'] = 'freq';
$ParametersList['type'] = '';
$ParametersList['own_element'] = '';

$elements_freq 			= LapsicHashTag::GetElementsList($ParametersList);

?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | Search</title>
<?php 
    include_once('include/resources.php');
    include_once('js/search.php'); 
    //<script type="text/javascript" src="js/search.js" defer></script>
?>

<script type="text/javascript" defer>
/*
$(document).ready(function(e) {
	$('.button-chiudi').click(function(){
	console.log('chiudi');
	//parent.$.fancybox.close();
    try{
        parent.jQuery.fancybox.close();
    }catch(err){
        parent.$('#fancybox-overlay').hide();
        parent.$('#fancybox-wrap').hide();
    }
});
    
});
*/



</script>
</head>
<body style="height: 100%;">
<!-- BOX CERCA  -->
<div class="container-cerca">
 <div class="content-cerca">
 	<?php /*
     <div class="button-chiudi">
  	chiudi <span>x</span>
  </div> */ ?>
  <div class="contenitore-box-cerca">
  	<div class="box-cerca">
    	<div>
        <img src="/images/cerca.png" width="18" height="16" alt=""/>
        SEARCH
      </div>
      <div class="input-cerca">
        <input type="text" id="search_text" value="<?php echo(isset($_text)?$_text : '') ?>" />
      </div>
      <div class="tipo-di-ricerca">
        <p class="ricerca-persone pointer" id="tab_user"><span>people(0)</span></p>
        <p class="ricerca-hashtag pointer" id="tab_photo">photo(0)</p>
      </div>
      <div class="spacer-cerca"></div>
      <div class="content-utente-cerca">
        <div id="user_search" class="box-utente-cerca iso-container-user" style="display: block; width: 100%; !important">
        </div>
        <div id="photo_search" class="box-utente-cerca iso-container-photo" style="display: none; width: 100%; !important">
        </div>
      </div>
      
      <div class="spacer-cerca"></div>
      <div class="ricerche-frequenti">
        Popular searches
      </div>
    </div>

    <?php if(sizeof($elements_freq) > 0) { ?>
        <?php foreach ($elements_freq as $el) {?>
    <div class="box-parole-cercate">
    	<?php echo '#'.$el['tag_name']; ?>
    </div>
        <?php } ?>        
    <?php } /* ?>  
    <div class="box-parole-cercate">
    	dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor in 
    </div>
    <div class="box-parole-cercate">
    	dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor in 
    </div>
    <div class="box-parole-cercate">
    	dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor in 
    </div>
    <div class="box-parole-cercate">
    	dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor in 
    </div>
    <div class="box-parole-cercate">
    	dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor in 
    </div>
    <div class="box-parole-cercate">
    	dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor in 
    </div>
    <?php */ ?>	
  </div>
 </div>
</div>
<!-- BOX CERCA  -->
</body>
</html>
