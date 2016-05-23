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

        ini_set('display_startup_errors',1);
        ini_set('display_errors',1);
        error_reporting(-1);
        
$element = new LapsicPhoto($db);

$erro = 'false';   
$my_profile = false;
if(isset($id)) {
	
	if(!$element->GetElement($id)){
		header('Location: index.php?resp_code=615');
		exit ();
	}
}
else
{
	$erro = 'true';    
}
 
    //echo 'TIMER <br>';
    $ParametersList['types_timer']         = 'image';
    $ParametersList['types']               = 'timer';
    // $ParametersList['elements_in_page']    = 30;
    $ParametersList['id_element']         = $element->id;
    $elements 			= LapsicNotification::GetElementsListRelation($ParametersList);
    //echo $element->id_owner.' === '.$lapsic_user->id;
    if($element->id_owner == $lapsic_user->id)
    {       
        //echo 'sono nel mio profilo';
        //echo '<br>';
        $my_profile = true;
        //var_dump($my_profile);
    }
*/    
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | Photo - Dave</title>
<?php include_once('include/resources.php'); ?>
  <script type="text/javascript" defer>

$(document).ready(function(e) {
    
    if(<?php echo ($erro); ?> == 'true')
    {        
        try{
            parent.jQuery.fancybox.close();
        }catch(err){
            parent.$('#fancybox-overlay').hide();
            parent.$('#fancybox-wrap').hide();
        }
    }
    update();
    
});

</script>

</head>

<body>
<?php include('include/googanal.php'); ?>


<div class="content-dett-img">
    <div class="button-chiudi">
        chiudi <span>x</span>
    </div>
    <div class="contenitore-dett-img">
        <div class="descr-dett-img">
            <p class="name-profile-zoom">lorem ipsum dolor sit amet lorem ipsum dolor sit amet</p>
            <div class="spacer-name-zoom-img"></div>
            <p class="posizione-profile-zoom">#235232</p>
            <p class="descr-profile-zoom">
                <a class="nounderline fancybox.ajax" style="color:#96cbf3" href="/box-cerca.php?text=sicily" data-fancybox-type="ajax">#lorem ipsum dolor sit amet</a> 
                <a class="nounderline fancybox.ajax" style="color:#96cbf3" href="/box-cerca.php?text=scaladeiturchi" data-fancybox-type="ajax">#scaladeiturchi</a> 
                <a class="nounderline fancybox.ajax" style="color:#96cbf3" href="/box-cerca.php?text=amici" data-fancybox-type="ajax">#lorem ipsum dolor sit ametlorem ipsum dolor sit amet</a> 
                <a class="nounderline fancybox.ajax" style="color:#96cbf3" href="/box-cerca.php?text=fanghisalutari" data-fancybox-type="ajax">#fanghisalutari</a>
            </p>
            <div class="spacer-name-zoom-img"></div>
            <p class="descr-profile-zoom">
                TIMED BY<br />
                <a class="nounderline" target="_top" href="profile.php?id=109">lorem ipsum dolor sit amet lorem ipsum dolor sit amet,</a><a class="nounderline" target="_top" href="profile.php?id=109">Shanti lorem ipsum dolor sit amet,</a><a class="nounderline" target="_top" href="profile.php?id=109">Shanti Silaro,</a><a class="nounderline" target="_top" href="profile.php?id=109">Shanti Silaro,</a><a class="nounderline" target="_top" href="profile.php?id=109">Shanti Silaro,</a>
                 >>        
                  
            </p> 
            
            <div class="tempo-profilo white" id="counter_12" title="2015-10-03 16:09:07" data-countdown="2015-10-03 16:09:07">
                <img src="images/orologio.png" width="16" height="16" alt=""/> 
                3 ws 5 ds 20:37:03
            </div>
            <?php if(true) { ?>  
            <div class="spacer-name-zoom-img"></div>
            <p class="descr-profile-zoom">
                <a target="_parent" class="nounderline" href="edit_photo.php">edit > </a>
            </p>
            <?php } ?>
            
        </div>
        <div class="img-dett-zoom">
            <?php //$dimensions = ElabImg('media/image/',$element->source_path); ?>
            <img src="http://test.lapsic.it/media/image/4e21a4dadca7c2f3715bbd6b7d41314d.jpg" width="100%" alt="" style="background-color: #887C6C;">
            
            <div class="esagono-abs" id="1">
                <p class="piu-ore">+24h AGGIUNGI ALTRI ESAGONI CON I +3 +6 +12</p>
            </div>
        </div>
    </div>
</div>





</body>
</html>
