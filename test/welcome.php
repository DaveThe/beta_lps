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

include(dirname(__FILE__).'/config/social/class/Social.php');
$s_login = new Social();
/*
$ParametersList['pagination'] = true;
$elements 			= HomeBlock::GetElementsList($ParametersList);*/
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | Benvenuti</title>
<link rel="stylesheet" type="text/css" href="css/reset-all.css">
<link rel="stylesheet" type="text/css" href="css/flexslider.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/common.css">
<link rel="stylesheet" type="text/css" href="js/fancy/jquery.fancybox.css">


<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="js/jquery.transform.js"></script>
<script type="text/javascript" src="js/jquery-animate-css-rotate-scale.js"></script>
<script type="text/javascript" src="js/fancy/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="js/isotope.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/parallax.js"></script>
<script type="text/javascript">

</script>

</head>

<body>


<div id="home" class="parallax-window" data-parallax="scroll" data-image-src="images/bg-home.jpg"></div>

	<div class="box-login">
  	<div class="int-login-relative">
    	<div class="logo">
      	<img src="images/logo.png" width="362" alt=""/>
      </div>
      <div class="content-input">
      <?php if(sizeof($errors)>0) 
	{ 
		foreach($errors as $elem)
		{
	?>		
		<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<b>Alert!</b> <?php echo($elem); ?>
		</div>
	<?php } 
	
	} ?>
      	<div class="box-accedi">
            <form method="post" action="welcome.php">
                <input type="hidden" name="act" value="login" />
                  <div class=" box-input-white-opaco" <?php echo((isset($errors) && sizeof($errors)>0)? 'style="background: rgba(244, 196, 196, 0.5) !important;"': '') ?>>
                    <input type="text" placeholder="Nome utente" id="utente" name="utente"/>
                    <input type="password" placeholder="Password" id="password_login" name="password"/>
                  </div>
                  <button type="submit" class="box-input-submit-big">accedi</button>
           </form>
          <!--
          <button class="box-input-submit-big">
              <a href="index-loggato.php" style="color:#FFF; text-decoration:none;">accedi</a>
          </button> -->
          <button class="box-input-submit-small" id="registrati">
              registrati
          </button>
        </div>
        <div class="box-registrati">   
            <form method="post" action="welcome.php">
                <input type="hidden" name="act" value="register" />
                <div class=" box-input-white-opaco">
                    <input type="text" placeholder="Email" id="email" name="email"  value="<?php echo(isset($lapsic_user->email)? $lapsic_user->email :''); ?>"/>
                    <input type="password" placeholder="Password" id="password_register" name="password"/>
                    <input type="text" placeholder="Nome utente" id="nickname" name="nickname"  value="<?php echo(isset($lapsic_user->nickname)? $lapsic_user->nickname :''); ?>"/>
                </div>
                <button class="box-input-submit-big ">
                  registrati
                </button>
            </form> 
            <button class="box-input-submit-small " id="accedi">
                accedi
            </button>
        </div>
        <div onClick="clickBtn();render();" id="customBtn" style="background-color:#E81B1F; color:#FFF; cursor:pointer;">GOOGLE PLUS LOGIN</div>
        <br><br>
        <div onClick="FBLogin();" style="background-color:#3A74DB; color:#FFF; cursor:pointer;">FACEBOOK LOGIN</div> 
      </div>
    </div>
  </div>
  
    <div class="box-bottom-cose-lapsic secondo_block">
        <p>cos’è lapsic?</p>
        <img src="images/arrow-bottom.png" width="20" height="12" alt=""/>
    </div>
    <div id="001" class="parallax-window" data-parallax="scroll" data-image-src="images/slider/001.jpg">
        <div class="box-bottom-cose-lapsic terzo_block">
            <p>perché usarlo?</p>
            <img src="images/arrow-bottom.png" width="20" height="12" alt=""/>
        </div>
        <div style=" height: 100%; text-align: center; line-height: 70px; color: white; font-size: 30px; padding: 200px;">  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam erat ante, imperdiet id blandit in, dignissim quis orci. Curabitur porttitor tortor volutpat, sollicitudin libero in, porttitor lectus.</p>  </div>  
    </div>
    
    <div id="005" class="parallax-window" data-parallax="scroll" data-image-src="images/slider/005.jpg">
        <div class="box-bottom-cose-lapsic quarto_block">
            <p>Vamonos?</p>
            <img src="images/arrow-bottom.png" width="20" height="12" alt=""/>
        </div>
        <div style=" height: 100%; text-align: center; line-height: 70px; color: white; font-size: 30px; padding: 200px;">  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam erat ante, imperdiet id blandit in, dignissim quis orci. Curabitur porttitor tortor volutpat, sollicitudin libero in, porttitor lectus.</p>  </div>
    </div>
    
    <div id="006" class="parallax-window" data-parallax="scroll" data-image-src="images/slider/002.jpg">
    
        <div style=" height: 100%; text-align: center; line-height: 70px; color: white; font-size: 30px; padding: 200px;">  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam erat ante, imperdiet id blandit in, dignissim quis orci. Curabitur porttitor tortor volutpat, sollicitudin libero in, porttitor lectus.</p>  </div>
    </div>
    

  
  <?php /*
    <?php if(sizeof($elements) > 0) { ?>
        <?php foreach ($elements as $el) {?>
            <div class="box-bottom-cose-lapsic block_<?php echo ($el['id']); ?>">
                <p class="block_<?php echo ($el['id']); ?>"><?php echo ($el['title']); ?></p>
                <img src="images/arrow-bottom.png" width="20" height="12" alt=""/>
            </div>
            <div id="block_<?php echo ($el['id']); ?>" class="second-container" style="height:1000px; background-color:#FFF; ">
            <?php echo ($el['text']); ?>
            </div>
        <?php } ?>        
    <?php } ?> */ ?> 

<?php /*****PARTE JAVASCRIPT PER FB e GOOGLE*****/ ?>
<?php include(dirname(__FILE__).'/config/social/include/fb_inc.php'); ?>
<?php include(dirname(__FILE__).'/config/social/include/go_inc.php'); ?>

</body>
</html>
