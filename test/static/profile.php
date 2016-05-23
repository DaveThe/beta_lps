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
//include_once('check_login.php');

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


$mode = (isset($_GET['filter']) && $_GET['filter']) ? $_GET['filter'] : '';

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
*/
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | #1 - Dave's Profile</title>
<?php include_once('include/resources.php'); ?>
<script type="text/javascript">
var modeClass = '<?php echo ( ($mode == 'timers' || $mode == 'timing')? '.box-altri-profili' : '.item' ); ?>';
var modeMasonry = <?php echo ( ($mode == 'timers' || $mode == 'timing')? '300' : '200' ); ?>;
</script>
<script type="text/javascript" src="js/profile.js" defer></script>


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
                    <p class="nome-profilo-dett">lorem ipsum dolor sit ametlorem ipsum dolor sit ametlorem ipsum dolor sit ametlorem ipsum dolor sit ametlorem ipsum dolor sit amet</p>
                    <p class="time-profilo-dett"><a class="nounderline" href="">Timing</a></p>
                    <p class="time-profilo-dett"><a class="nounderline"  href="">Timers</a></p>
                </div> 
                <div class="numeri-profilo-right">
                    <p class="codice-utente">
                    #1
                    </p>
                    <p class="time-profilo-numeri"><a class="nounderline"  href="">3812319832198372329</a></p>
                    <p class="time-profilo-numeri"><a class="nounderline"  href="">12324234638475345</a></p>
                </div>
            </div>
            <div class="img-profilo-dettaglio">
                <img src="http://test.lapsic.it/media/avatar/99abb31564f1e74e0727becc1e780114.jpg" alt=""/>
            </div>
        </div>
        <div class="box-descrizione-profilo">
            <ul><li class="descr-txt">Total pics time ></li> <li class="risultato-txt" data-countdown="2015-09-03 05:00:21">2015-09-03 05:00:21</li></ul>
            <ul><li class="descr-txt">Gender > </li> <li class="risultato-txt">male</li></ul>
            <ul><li class="descr-txt">Place ></li> <li class="risultato-txt"> Lissone, Italia</li></ul>
            <ul><li class="descr-txt">Description ></li> <li class="risultato-txt">  Ciao, sono un giovane appassionato di foto, e voglio vincere almeno un concorso mensile Lapsic! Sono sicuro che con impegno e dedizione ce la farò!</li></ul>
  
        
            <ul><li class="descr-txt"><a class="nounderline" href="profile_edit.php">edit > </a></li></ul>
        </div>
    </div>

    <div id="cont-box-profili" class="cont-box-profili">
        '<p>INVENTATI UN RETTANGOLO O QUALCOSA PER SEGNALARE QUESTE SITUAZIONI..<br>STESSA COSA PER I SUCCESS <br>Utente non trovato! Ti abbiamo riportato al tuo profilo!</p>
        
        <!-- SE QUA RIESCI A USARE UN SOLO CONTAINER PER LE DUE TIPOLOGIE MI FAI UN FAVORE :)  -->
        <?php echo ( ($mode == 'timers' || $mode == 'timing')? '' : '<div class="cont-single-box-profili">' ); ?>        
         
        <?php if(1 > 0) { ?>
            <?php if($mode == 'timers' || $mode == 'timing') { ?>
                             
                
                    <div class="box-altri-profili">      
                        <div class="box-dettaglio-profilo fl_none">
                          <div class="box-numeri-profilo">
                              <div class="numeri-profilo-left">
                                <p class="nome-profilo-dett"><a class=" nounderline" style="" href="">lorem ipsum dolor sit ametlorem ipsum dolor sit ametlorem ipsum dolor sit amet</a></p>
                                <p class="time-profilo-dett">Timing</p>
                                <p class="time-profilo-dett">Timers</p>
                             </div> 
                             <div class="numeri-profilo-right">
                              <p class="codice-utente">
                                  #3000
                              </p>
                                <p class="time-profilo-numeri">9999999</p>
                                <p class="time-profilo-numeri">999999</p>
                             </div>
                          </div>
                          <div class="img-profilo-dettaglio">
                            <img class="lazy" src="http://test.lapsic.it/media/avatar/99abb31564f1e74e0727becc1e780114.jpg" alt=""/>
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
                    
                    <div class="box-altri-profili">      
                        <div class="box-dettaglio-profilo fl_none">
                          <div class="box-numeri-profilo">
                              <div class="numeri-profilo-left">
                                <p class="nome-profilo-dett"><a class=" nounderline" style="" href="">lorem ipsum dolor sit ametlorem ipsum dolor sit ametlorem ipsum dolor sit amet</a></p>
                                <p class="time-profilo-dett">Timing</p>
                                <p class="time-profilo-dett">Timers</p>
                             </div> 
                             <div class="numeri-profilo-right">
                              <p class="codice-utente">
                                  #3000
                              </p>
                                <p class="time-profilo-numeri">9999999</p>
                                <p class="time-profilo-numeri">999999</p>
                             </div>
                          </div>
                          <div class="img-profilo-dettaglio">
                            <img class="lazy" src="http://test.lapsic.it/media/avatar/99abb31564f1e74e0727becc1e780114.jpg" alt=""/>
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
                    
                    <div class="box-altri-profili">      
                        <div class="box-dettaglio-profilo fl_none">
                          <div class="box-numeri-profilo">
                              <div class="numeri-profilo-left">
                                <p class="nome-profilo-dett"><a class=" nounderline" style="" href="">lorem ipsum dolor sit ametlorem ipsum dolor sit ametlorem ipsum dolor sit amet</a></p>
                                <p class="time-profilo-dett">Timing</p>
                                <p class="time-profilo-dett">Timers</p>
                             </div> 
                             <div class="numeri-profilo-right">
                              <p class="codice-utente">
                                  #3000
                              </p>
                                <p class="time-profilo-numeri">9999999</p>
                                <p class="time-profilo-numeri">999999</p>
                             </div>
                          </div>
                          <div class="img-profilo-dettaglio">
                            <img class="lazy" src="http://test.lapsic.it/media/avatar/99abb31564f1e74e0727becc1e780114.jpg" alt=""/>
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
                    
                <?php //} ?> 
            
            <?php } else { ?>
        
                    <?php /*foreach ($elements as $el) {
                        $dimensions = ElabImg('media/image/medium/',$el['source_path']);*/
                    ?>
                        <div class="item" style="width: 200px;height: 150px;">
                            <img class="img-zoom lazy" data-src="http://test.lapsic.it/media/image/medium/80c5e43e62ef1786844d986e2c4edd6e_200X150.jpg" border="0" alt="sto cazzo" width="200" height="150" style="background-color: rgb(174, 156, 142);" />
                            <a class="dettaglio-photo fancybox.ajax" href="/photo.php" data-fancybox-type="ajax"><img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt="12"/></a>
                            <div class="box-date-hour" style="display: block;">
                                <div class="date-item" id="counter_12" title="2015-10-03 16:09:07" data-countdown="2015-10-03 16:09:07">
                                    3 ws 5 ds 20:37:03
                                </div>
                                <div class="add-hour" id="12">
                                    +24 h <!-- RICORDA GLI ALTRI ORARI +3 +6 +12 -->
                                </div>
                            </div>
                            <div class="name-profile-photo" style="display: block;">
                                <a class="href_nn" style="color: white;" href="profile.php">
                                    lorem ipsum dolor sit amet lorem ipsum dolor sit amet
                                    <span>#430020</span>
                                </a>
                            </div>
                        </div>
                    <?php //} ?>  
                              
                <?php } ?>  
                   
          <?php } else { ?>
                <p>Inizia a caricare delle immagini!!</p>
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
