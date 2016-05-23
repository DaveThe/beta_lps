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
include_once('item_list.php');
include_once('check_login.php');

$element    = new $lapsic_user($db);
//$timers     = new LapsicNotification($db);

$my_profile = false;
$error_id   = false;

if(isset($id)) 
{   
    //echo 'id presente - '.$id;
    //echo '<br>';
	if(!$element->GetElement($id))
    {
		header('Location: index.php?resp_code=615');
		exit ();
	}
    //echo $element->id .'==='. $lapsic_user->id;
    //echo '<br>';
    if($element->id === $lapsic_user->id)
    {
        $my_profile = true;
    }
    
}
else
{    
    //echo 'id NON presente ';
    //echo '<br>';
    if(isset($lapsic_user->id) && $lapsic_user->id != '')
    {
        //echo'sono già loggato e recupero id - '.$lapsic_user->id;
        //echo '<br>';
        $id         = $lapsic_user->id;
    }
    else
    {
        $error_id   = true;
        header('Location: index.php?resp_code=615');
        exit ();
    }
    
    
	if(!$element->GetElement($id)){
		header('Location: index.php?resp_code=615');
		exit ();
	}
    
    //echo $element->id .'==='. $lapsic_user->id;
    //echo '<br>';
    if($element->id === $lapsic_user->id)
    {       
        //echo 'sono nel mio profilo';
        //echo '<br>';
        $my_profile = true;
    }    
}

$ParametersList['pagination']           = true;
$ParametersList['elements_in_page']     = 10;
$ParametersList['type']                 = 'timer';
$ParametersList['own_element']          = $element->id;

//$timers 			                    = LapsicNotification::GetElementsListRelation($ParametersList);


$mode = (isset($_GET['filter']) && $_GET['filter']) ? trim($_GET['filter']) : '';

if($mode == 'timers')
{ 
    //echo 'TIMER <br>';
    $ParametersList['types_timer']         = 'timer';
    $ParametersList['types']               = 'timer';
    // $ParametersList['elements_in_page']    = 30;
    $ParametersList['own_element']         = $element->id;
    $elements 			= LapsicNotification::GetElementsListRelation($ParametersList);//= $lapsic_user::GetElementsList($ParametersList);    
}
elseif($mode == 'timing')
{ 
    //echo 'TIMING <br>';
    //$ParametersList['types']         = 'timing';
    //$ParametersList['elements_in_page']     = 30;
    //
    $ParametersList['own_element']   = '';
    $ParametersList['types_timer']         = 'timing';    
    $ParametersList['types']         = 'timer';
    // $ParametersList['elements_in_page']     = 30;
    $ParametersList['source']   = $element->id;
    $elements 			= LapsicNotification::GetElementsListRelation($ParametersList);    
}
else
{   
    $ParametersList['own_element'] = $element->id;
    $elements 			= LapsicPhoto::GetElementsList($ParametersList);
}

?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | #<?php echo ($element->rank.' - '.$element->nickname); ?>'s Profile</title>
<?php include_once('include/resources.php'); ?>
<script type="text/javascript">
var modeClass = '<?php echo ( ($mode == 'timers' || $mode == 'timing')? '.box-altri-profili' : '.item' ); ?>';
var modeMasonry = <?php echo ( ($mode == 'timers' || $mode == 'timing')? '300' : '200' ); ?>;
</script>
<script type="text/javascript" src="/js/profile.js" defer></script>
<script type="text/javascript" src="js/editPhoto.js" defer></script>


<style>
@media (max-width:960px)and (min-width:768px)
{
	.cont-box-profili{ width:630px; }
}
@media (max-width:767px)
{
	.cont-box-profili{ max-width:415px; margin:auto; }
	
}
</style>
</head>

<body>
<?php include('include/googanal.php'); ?>

<div class="second-container">


		<?php include ("include/header.php"); ?>
        
  <div class="content-profilo">
  
    <div class="dettaglio-profilo-left">
        
        <div class="box-dettaglio-profilo">
            <div class="box-numeri-profilo">
                <div class="numeri-profilo-left">
                    <p class="nome-profilo-dett"><?php echo ( wordwrap( ucfirst ( strtolower ( (isset($element->nickname) && $element->nickname != '') ? $element->nickname : $element->username ) ), 12, "<br />\n") ); ?></p>
                    <p class="time-profilo-dett"><a class="nounderline" href="profile.php?id=<?php echo ($element->id); ?>&filter=timing">Timing</a></p>
                    <p class="time-profilo-dett"><a class="nounderline"  href="profile.php?id=<?php echo ($element->id); ?>&filter=timers">Timers</a></p>
                </div> 
                <div class="numeri-profilo-right">
                    <p class="codice-utente">
                    <a href="index.php?mode=rankuser" class="nounderline">
                    #<?php echo ($element->rank); ?>
                    </a>
                    </p>
                    <p class="time-profilo-numeri"><a class="nounderline"  href="profile.php?id=<?php echo ($element->id); ?>&filter=timing"><?php echo ($element->timers); ?></a></p>
                    <p class="time-profilo-numeri"><a class="nounderline"  href="profile.php?id=<?php echo ($element->id); ?>&filter=timers"><?php echo ($element->timing); ?></a></p>
                </div>
            </div>
            <div class="img-profilo-dettaglio">
                <img src="/media/avatar/<?php echo ( ( (isset($element->img) && $element->img != '') ? $element->img : 'avatar.png') ); ?>" alt=""/>
            </div>
        </div>
        <div class="box-descrizione-profilo">
            <ul><li class="descr-txt">Total pics time ></li> <li class="risultato-txt" <?php echo(($element->time_left != '0000-00-00 00:00:00') ? 'title="'.strtotime($element->time_left).'" now="'.time().'" data-countdown="'.$element->time_left.'"' : '' ); ?>>0</li></ul>
            <ul><li class="descr-txt">Gender > </li> <li class="risultato-txt"><?php echo (($element->gender == '1')? 'female' : 'male'); ?></li></ul>
            <?php if(($element->country != '' && $element->country != 'NULL') || ($element->city != '' && $element->city != 'NULL')) { ?> <ul><li class="descr-txt">Place ></li> <li class="risultato-txt"> <?php echo (($element->city != '' && $element->city != 'NULL')?$element->city.',':''); ?> <?php echo (($element->country != '' && $element->country != 'NULL') ? $element->country : ''); ?></li></ul> <?php } ?>
            <ul><li class="descr-txt">Description ></li> <li class="risultato-txt"> <?php echo (($element->note != '' && $element->note != 'NULL')?trim($element->note):'nothing here at the moment!'); ?></li></ul>
            <?php /*<ul><li class="descr-txt">Edit profile ></li> <li class="risultato-txt"> <?php echo (($element->note != '')?$element->note:'nothing here at the moment!'); ?></li></ul> */ ?>
        
          <?php if($my_profile) { ?> <ul><li class="descr-txt"><a class="nounderline" href="profile_edit.php?id=<?php echo($element->id); ?>">edit > </a></li></ul> <?php } ?>
        </div>
    </div>

    <div id="cont-box-profili" class="cont-box-profili iso-container">
        <?php echo (($error_id) ? '<p>Utente non trovato! Ti abbiamo riportato al tuo profilo!</p>' : '' ); ?>
        
        <?php echo ( ($mode == 'timers' || $mode == 'timing')? '' : '<div class="cont-single-box-profili">' ); ?>        
        <?php /* <div class="<?php echo ( ($mode == 'timers' || $mode == 'timing')? 'box-altri-profili' : 'cont-single-box-profili' ); ?>"> */ ?> 
        <?php if(sizeof($elements) > 0) { ?>
            <?php if($mode == 'timers' || $mode == 'timing') { ?>
                
                <?php 
                    echo printItemsUser($elements, $ParametersList);
                /* ?>             
                <?php foreach ($elements as $el) { ?>
                
                    <div class="box-altri-profili">      
                        <div class="box-dettaglio-profilo fl_none">
                          <div class="box-numeri-profilo">
                              <div class="numeri-profilo-left">
                                <p class="nome-profilo-dett"><a class=" nounderline" style="" href="profile.php?id=<?php echo ($el['id']); ?>"><?php echo ( (isset($el['nickname']) && $el['nickname'] != '') ? $el['nickname'] : $el['username'] ); ?></a></p>
                                <p class="time-profilo-dett">Timing</p>
                                <p class="time-profilo-dett">Timers</p>
                             </div> 
                             <div class="numeri-profilo-right">
                              <p class="codice-utente">
                                  #<?php echo ($el['rank']); ?>
                              </p>
                                <p class="time-profilo-numeri"><?php echo ($el['timing']); ?></p>
                                <p class="time-profilo-numeri"><?php echo ($el['timers']); ?></p>
                             </div>
                          </div>
                          <div class="img-profilo-dettaglio">
                            <img class="lazy" src="media/avatar/<?php echo ( ( (isset($el['img']) && $el['img'] != '') ? $el['img'] : 'avatar.png') ); ?>" alt=""/>
                         </div>
                        </div>
                        
                        <div class="box-img-altri-profili">
                        	<div class="box-img-top lazy" style="background-image: url(images/slider/001.jpg);">
                          </div>
                        	<div class="box-img-top lazy" style="background-image: url(images/slider/002.jpg);">
                          </div>
                        	<div class="box-img-top lazy" style="background-image: url(images/slider/003.jpg);">
                          </div>
                          <div class="box-img-bottom lazy" style="background-image: url(images/slider/004.jpg);">
                          </div>
                        </div>
                    </div>
                <?php } ?> 
                <?php */ ?>
            <?php } else { ?>
        
                    <?php 
                        echo printItems($elements,$my_profile); 
                    /*foreach ($elements as $el) {
                        $dimensions = ElabImg('/media/image/medium/',$el['source_path']);
                    ?>
                        <div class="item" style="width: <?php echo ($dimensions['width']); ?>px;height: <?php echo ($dimensions['height']); ?>px;">
                            <img class="img-zoom lazy" data-src="<?php echo ($dimensions['name'] ); ?>" border="0" alt="<?php echo ($el['name']); ?>" width="<?php echo ($dimensions['width']); ?>" height="<?php echo ($dimensions['height']); ?>" style="background-color: #<?php echo ($el['average_colour']); ?>;" />
                            <a class="dettaglio-photo fancybox.ajax" href="/photo.php?id=<?php echo ($el['id']); ?>" data-fancybox-type="ajax"><img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt="<?php echo ($el['id']); ?>"/></a>
                            <div class="box-date-hour" style="display: block;">
                                <div class="date-item" id="counter_<?php echo ($el['id']); ?>" title="<?php echo ($el['time_left']); ?>" data-countdown="<?php echo (adaptTime($el['time_left'])); ?>">
                                    112d:04h
                                </div>
                                <div class="add-hour" id="<?php echo ($el['id']); ?>">
                                    +24 h
                                </div>
                            </div>
                            <div class="name-profile-photo" style="display: block;">
                                <a class="href_nn" style="color: white;" href="profile.php?id=<?php echo ($el['id_owner']); ?>">
                                    <?php echo ($el['user']); ?>
                                    <span>#<?php echo ($el['rank']); ?></span>
                                </a>
                            </div>
                        </div>
                    <?php } */ ?>  
                          
                <?php } ?>  
                   
          <?php } else { ?>
                <p style="text-align: center;">Ups, no photo here, why? time is slipping away!! </p>
          <?php } ?>	   
        	<div id="pagination" style="display: none;">
                <?php echo ( ($_pag != $elements->getPages()->pageCount) ? '<a href="'. $_SERVER['PHP_SELF'] .'?filter='.$mode.'&pag='.($_pag+1).'&'.$querystring.'" class="next">next</a>' : ''); ?>
            </div>
          
         <?php echo ( ($mode == 'timers' || $mode == 'timing')? '' : '</div>' ); ?> 
      
    </div>
  </div>
</div>

    <?php include ("include/footer.php");?>

</body>
</html>
