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
include_once('check_login.php');

if(!isset($_SESSION['lapsic_logged']) || $_SESSION['lapsic_logged'] == false) {
    include(dirname(__FILE__).'/config/social/class/Social.php');
    //$s_login = new Social();
}

//include_once('check_login.php');
$ParametersList['pagination'] = true;
$ParametersList['elements_in_page'] = 20;
$mode = (isset($_GET['mode']) && $_GET['mode']) ? $_GET['mode'] : '';

$ParametersList['order']    = $mode;
$ParametersList['source']   = $lapsic_user->id;
$ParametersList['status']   = ENABLE;
$elements 			= LapsicPhoto::GetElementsList($ParametersList);
*/
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | Benvenuti</title>
<meta name="description" content="hype sensitive photography – which pics will stand the test of time?">
<?php include_once('include/resources.php'); ?>
<script type="text/javascript" src="js/home.js" defer></script>
<style type="text/css">
.header-int{ max-width:1394px;}
</style>
</head>

<body>
    <?php include('include/googanal.php'); ?>
        
    <div class="second-container">    
        
        <?php include ("include/header.php");?>
        
        <div class="container-menu-e-blocchi">
                 
        <?php //if(!isset($_SESSION['lapsic_logged']) || $_SESSION['lapsic_logged'] == false) { ?>
            <!--Slider -->
            <div class="box-cont-slider">
                <div id="sliderhome" class="cont-slider">
                    <ul class="slides">
                      <li style="background:url(images/slider/001.jpg);" class="img-slider" style="background-color: #889182;">
                        <div class="box-dida-slider">
                          Upload your pics and survive the countdown 
                          <span>pic by Alessandro Bianchi</span>
                        </div>
                      </li>
                      <li style="background:url(images/slider/002.jpg);" class="img-slider" style="background-color: #68572E;">
                        <div class="box-dida-slider">
                          Each pic has a 24hr life span
                          <span>pic by Alessandro Bianchi</span>
                        </div>
                      </li>
                      <li style="background:url(images/slider/003.jpg);" class="img-slider" style="background-color: #555249;">
                        <div class="box-dida-slider">
                          Dominate the home page with your best & proudest pics
                          <span>pic by Alessandro Bianchi</span>
                        </div>
                      </li>
                      <li style="background:url(images/slider/004.jpg);" class="img-slider" style="background-color: #7B70B5;">
                        <div class="box-dida-slider">
                          TIME your friend’s pics and support them on Lapsic!
                          <span>pic by Alessandro Bianchi</span>
                        </div>
                      </li>
                      <li style="background:url(images/slider/005.jpg);" class="img-slider" style="background-color: #77474B;">
                        <div class="box-dida-slider">
                          Add 24hrs of Lapsic TIME to each pictures you "like"
                          <span>pic by Alessandro Bianchi</span>
                        </div>
                      </li>
                      <li style="background:url(images/slider/005.jpg);" class="img-slider" style="background-color: #77474B;">
                        <div class="box-dida-slider">
                          Join Lapsic and see if your pics will stand the test of time
                          <span>pic by Alessandro Bianchi</span>
                        </div>
                      </li>
                    </ul>
                </div>
            </div>
            <!--Slider -->  
            
            
            <!--navigation blocchi -->
           
            <div class="spacer-slider-blocchi">
            	<ul>
                <li>
                  <a class="nounderline" href="index.php">best on lapsic</a>
                </li>
                <?php /*?><li>
                  best on lapsic
                </li><?php */?>
              </ul>
            </div>
            <!--navigation blocchi -->
       <?php //} ?>   
            
            <div id="container-blocchi">
                <?php if(1 > 0) { ?>
                    <?php //foreach ($elements as $el) {
                        //$dimensions = ElabImg('media/image/medium/',$el['source_path']);
                    ?>
                        <div class="item" style="width: 200px;height: 266px;">
                            <img class="img-zoom lazy" data-src="http://test.lapsic.it/media/image/medium/35aa63c24789f528881097407916cbb0_200X266.jpg" border="0" alt="" width="200" height="266" style="background-color: rgb(131, 111, 97);" />                            
                            <a class="dettaglio-photo fancybox.ajax" href="/photo.php" data-fancybox-type="ajax"><img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt="12"/></a>
                            <div class="box-date-hour" style="display: block;">
                                <div class="date-item" id="counter_12" title="2015-10-04 06:02:24" data-countdown="2015-10-04 06:02:24">
                                    3 ws 5 ds 20:37:03
                                </div>
                                <div class="time_container">
                                    <div class="add-hour" id="12">
                                        +24 h
                                    </div>
                                    <div class="add-hour" id="12_12">
                                        +12 h
                                    </div>
                                    <div class="add-hour" id="6_12">
                                        +6 h
                                    </div>
                                    <div class="add-hour" id="3_12">
                                        +3 h
                                    </div>
                                </div>
                            </div>
                            <div class="name-profile-photo" style="display: block;">
                                <a class="href_nn" style="color: white;" href="profile.php?id=<?php echo ($el['id_owner']); ?>">
                                    lorem ipsum dolor sit amet lorem ipsum dolor sit amet
                                    <span>#12346</span>
                                </a>
                            </div>
                        </div>
                    <?php //} ?>        
                <?php } else { ?>  
                	<p>Oooops, il tempo è terminato... rifornire di foto!!</p>		
			     <?php } ?>
            </div>  
            <?php if(isset($_SESSION['lapsic_logged']) && $_SESSION['lapsic_logged']) { ?>  
            <div class="box-scroll-and-add">
                <a class="add-photo fancybox.ajax mfp-iframe" href="/add-photo.php" data-fancybox-type="ajax"><img src="images/add-image.png" width="52" alt=""/></a><br />
                <img src="images/scrolltop.png" width="52" id="scroll-top" alt=""/>
            </div>	   
            <?php } ?>
        	     
        </div>
    </div>
    
    <?php include ("include/footer.php");?>
    
<?php if(!isset($_SESSION['lapsic_logged']) || $_SESSION['lapsic_logged'] == false) { ?>    
    <?php /*****PARTE JAVASCRIPT PER FB e GOOGLE*****/ ?>
    <?php Social::getInstance()->generaJs('GO', (isset($Session['state'])? $Session['state'] :'') ); ?>
    <?php Social::getInstance()->generaJs('FB', (isset($Session['state'])? $Session['state'] :'')); ?>
    <?php //include(dirname(__FILE__).'/config/social/include/fb_inc.php'); ?>
    <?php //include(dirname(__FILE__).'/config/social/include/go_inc.php'); ?>
<?php } ?>
</body>
</html>
