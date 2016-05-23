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
include_once('check_login.php');
include_once('item_list.php');


//include_once('check_login.php');
$ParametersList['pagination'] = true;
$ParametersList['elements_in_page'] = 20;
$mode = (isset($_GET['mode']) && $_GET['mode']!='') ? trim($_GET['mode']) : '';

if($mode == 'rankuser')
{
    $ParametersList['order']    = $mode;
    $ParametersList['status']   = ENABLE;
    $elements 			= LapsicUser::GetElementsList($ParametersList);
}
else
{
    $ParametersList['order']    = $mode;
    $ParametersList['source']   = $lapsic_user->id;
    $ParametersList['status']   = ENABLE;
    $elements 			= LapsicPhoto::GetElementsList($ParametersList);    
}
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | Benvenuti</title>
<meta name="description" content="hype sensitive photography – which pics will stand the test of time?">
<?php include_once('include/resources.php'); ?>
<?php //<script type="text/javascript" src="js/home.js" defer></script> ?>
<style type="text/css">
.header-int{ max-width:1394px;}
</style>
</head>

<body>
    <?php include_once('include/googanal.php'); ?>
        
    <div class="second-container">    
        
        <?php include_once("include/header.php");?>
        
        <div class="container-menu-e-blocchi">
                 
        <?php if(!isset($_SESSION['lapsic_logged']) || $_SESSION['lapsic_logged'] == false) { ?>
            <!--Slider -->
            <?php include_once('slider.php'); ?>
            <!--Slider -->  
            
            
            <!--navigation blocchi -->
           
            <div class="spacer-slider-blocchi">
            	<ul>
                <li>
                  <a class="nounderline" href="index.php">best on lapsic</a>
                </li>
              </ul>
            </div>
            <!--navigation blocchi -->
       <?php } ?>   
            
            <div id="container-blocchi" class="iso-container">
            <?php if($mode == 'rankuser') { ?>
                <?php if(sizeof($elements) > 0) {
                        echo printItemsUser($elements, $ParametersList);
                } ?>  
 			<?php } else { ?>
                <?php if(sizeof($elements) > 0) {
                        echo printItems($elements);
                } ?>
            <?php } ?>
            </div>  
            <?php if(isset($_SESSION['lapsic_logged']) && $_SESSION['lapsic_logged']) { ?>  
            <div class="box-scroll-and-add">
                <a class="add-photo fancybox.ajax mfp-iframe" href="/add-photo.php" data-fancybox-type="ajax"><img src="images/add-image.png" width="52" alt=""/></a><br />
                <img src="images/scrolltop.png" width="52" id="scroll-top" alt=""/>
            </div>	   
            <?php } ?>
        	<div id="pagination" style="display: none;">
                <?php echo ( ($_pag != $elements->getPages()->pageCount) ? '<a href="'. $_SERVER['PHP_SELF'] .'?mode='.$mode.'&pag='.($_pag+1).'&'.$querystring.'" class="next">next</a>' : ''); ?>
            </div>	     
        </div>
    </div>
    
    <?php include_once("include/footer.php");?>
    
</body>
</html>
