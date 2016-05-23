<?php 
    namespace Lapsic;
    /*
    $ParametersList['pagination']   = false;
    $ParametersList['status']       = '0';
    $ParametersList['own_element']  = $lapsic_user->id;
    $notify                         = LapsicNotification::GetElementsList($ParametersList);
    */ 
?>
  
        
  <?php if( false && isset($resp_code) && $resp_code != '') {  ?>
        <!-- POPUP -->
        <ul class="popup">
        <? /* 
        <?php if($resp_code=='12'){ ?>
          <li class="popup-errore">
          	Ups somethings goes wrong!
          </li>
        <?php } ?>*/?>
        <?php if($resp_code=='12'){ ?>
          <li class="popup-errore">
          	Please, complete this form and start to share your photos!
          </li>
        <?php } ?>
        <?php if($resp_code=='110'){ ?>
    		<li class="popup-success">
            Yeah! Everything is ok!
            </li>
        </ul>  
        <?php } ?>
        <!-- POPUP -->
        
  <?php } ?>
    
   
    <?php if(!isset($_SESSION['lapsic_logged']) || $_SESSION['lapsic_logged'] == false) { ?>
        <!-- HEADER NEW HOME NO LOGGATO -->
        <?php //var_dump($errors); ?>
        
        <!-- LOGO SEMPRE PRESENTE -->
        <div class="logo-home-center">
            <a href="index.php"><img src="images/logo.png" class="img-logo" alt=""/></a>
        </div>
        
        <div class="box-ico-cerca-notifica">
            <div style="display:inline-block; vertical-align:top; ">
                <p class="hash-expo"><a href="/expo.php">#EXPO</a></p>
            </div>
        </div>
        <div class="txt-intro-home">
            <?php /* JOIN LAPSIC AND DISCOVER HOW LONG YOUR PICTURES CAN SURVIVE THE TIME */ ?>
            HYPE SENSITIVE PHOTOGRAPHY – WHICH PICS WILL STAND THE TEST OF TIME?
        </div>
        <?php
        if(sizeof($errors)>0)
        {
        ?>
            <div class="txt-intro-home" style="color: red !important;">
                Login errato
            </div>
        <?php } ?>
        <div class="box-login-home" <?php echo ( (PAGE_NAME != 'INDEX')?'style="margin-bottom: 10px;"' : ''); ?> >
            LOGIN
        </div>
        <div class="content-form-login">
            <div class="content-int-form-login">
                <div class="box-left-form-login" id="accedi">
                    <form method="post">
                        <input type="hidden" name="act" value="login" />
                        <input type="text" class="input-login" placeholder="Username or E-mail" id="utente" name="utente" <?php echo ((sizeof($errors)>0)?'style="border: 2px solid #D80000; color: red !important;"':''); ?> />
                        <input type="password" class="input-login" placeholder="password" id="password_login" name="password" <?php echo ((sizeof($errors)>0)?'style="border: 2px solid #D80000; color: red !important;"':''); ?>/>
                        <button type="submit" class="button-login">accedi</button>
                    </form>
                </div>
                <div class="box-left-form-login">
                    <p class="accedi-con-txt">accedi con</p>
                    <div class="box-social-login">
                        
                        <?php 
                        if(MODE != 'LOCALE'){$teeee = Social::getInstance();}
                        if(MODE != 'LOCALE'){$teeee->generaBottone('FB', '<img src="/images/fb_social_log.png" width="30" alt="" style="cursor: pointer;"/>');}
                        if(MODE != 'LOCALE'){$teeee->generaBottone('GO', '<img src="/images/goog_plus_social.png" width="30" alt="" style="cursor: pointer;"/>');} 
                        /*
                        <img onClick="FBLogin();" src="images/fb_social_log.png" width="30" alt="" style="cursor: pointer;"/>
                        <img onClick="clickBtn();render();" src="images/goog_plus_social.png" width="30" alt="" style="cursor: pointer;"/>
                        */
                        ?>
                    </div>
                </div>
                <div class="box-left-form-login">
                    <p class="accedi-con-txt">non sei ancora<br /> registrato?</p>
                    <div class="button-login"><a class="register fancybox.ajax"  href="/register.php" data-fancybox-type="ajax">registrati</a></div>
                </div>
            </div>
        </div>
        <!-- HEADER NEW HOME NO LOGGATO -->
    <?php } else { ?>
        <!-- HEADER NEW HOME LOGGATO -->
    
        <div class="logo-home-center" style="padding-top: 10px;">
          <a href="index.php"><img src="<?php Common::autoVer('/images/logo.png'); ?>" class="img-logo" alt=""/></a>
        </div>
        
        <div class="box-ico-cerca-notifica">
        	<div style="display:inline-block;">
            <?php /*<a class="box-cerca fancybox.ajax" href="/box-cerca.php" data-fancybox-type="ajax"><img src="images/ico-cerca.png" width="28" id="search" alt=""/></a> */ ?>
            <a class="box-cerca" href="cerca.php"><img src="/images/ico-cerca.png" width="28" id="search" alt=""/></a>
          </div>
        	<div style="display:inline-block; position:relative; display: none !important;">
          	<div class="num-notifiche">
            	10
            </div>
            <img src="images/ico-notifica.png" width="28" id="search" alt=""/>
          </div>
        	<div style="display:inline-block; vertical-align:top; ">
          	<p class="hash-expo"><a href="/expo.php">#EXPO</a></p>
          </div>
        </div>
		
        <div class="txt-intro-home" style="text-transform: uppercase;">
            <?php /* JOIN LAPSIC AND DISCOVER HOW LONG YOUR PICTURES CAN SURVIVE THE TIME */ 
            
                if(isset($mode) && $mode == 'new' && PAGE_NAME == 'INDEX')
                {
                    echo 'new pics by people i’m timing';
                }
                elseif(isset($mode) && $mode == 'timers' && PAGE_NAME == 'INDEX')
                {
                    echo 'best pics by people i’m timing';
                }
                elseif(isset($mode) && ($mode == '' || $mode == 'rank') && PAGE_NAME == 'INDEX')
                {
                    echo 'the most timed pictures on Lapsic';                    
                }
                elseif(PAGE_NAME == 'PROFILE')
                {
                    if(isset($mode) && $mode == 'timing')
                    {
                        echo 'people you are following';                        
                    }
                    elseif(isset($mode) && $mode == 'timers')
                    {
                        echo 'people following you ';                        
                    }
                    else
                    {
                        echo 'Help people find you';
                    }                        
                }
                elseif(PAGE_NAME == 'PROFILE_EDIT')
                {
                    echo 'Help people find you';
                }
            ?>
        </div>
        <div class="box-abs-what-and-time">
        	<ul>
          	<a href="index.php?mode=new" class="nounderline"><li <?php echo ((isset($mode) && $mode == 'new' && PAGE_NAME == 'INDEX') ? 'style ="background-color:#5F9CCA;"' : '') ?>> what's new</li></a>
          	<a href="index.php?mode=timers" class="nounderline"><li <?php echo ((isset($mode) && $mode == 'timers' && PAGE_NAME == 'INDEX') ? 'style ="background-color:#5F9CCA;"' : '') ?>> timing's best</li></a>
          </ul>
        </div>
        <?php if( ( PAGE_NAME == 'PROFILE' && !$my_profile) || ( PAGE_NAME != 'PROFILE') ) { ?>
        <div class="box-profilo-header">
            <div class="box-dettaglio-profilo">
                <div class="box-numeri-profilo">
                    <div class="numeri-profilo-left">
                        <p class="nome-profilo-dett"><a href="profile.php?id=<?php echo($lapsic_user->id); ?>" class="nounderline"><?php echo ( wordwrap(( ucfirst ( strtolower ( (isset($lapsic_user->nickname) && $lapsic_user->nickname != '') ? $lapsic_user->nickname : $lapsic_user->username ) )), 12, "<br />\n") ); ?></a></p>
                        <p class="time-profilo-dett"><a class="nounderline" href="profile.php?id=<?php echo ($lapsic_user->id); ?>&filter=timing">Timing</a></p>
                        <p class="time-profilo-dett"><a class="nounderline"  href="profile.php?id=<?php echo ($lapsic_user->id); ?>&filter=timers">Timers</a></p>
                    </div> 
                    <div class="numeri-profilo-right">
                        <p class="codice-utente">
                        <a href="index.php?mode=rankuser" class="nounderline">
                            #<?php echo ($lapsic_user->rank); ?>
                        </a>
                        </p>
                        <p class="time-profilo-numeri"><a class="nounderline" href="profile.php?id=<?php echo ($lapsic_user->id); ?>&filter=timing"><?php echo ($lapsic_user->timers); ?></a></p>
                        <p class="time-profilo-numeri"><a class="nounderline"  href="profile.php?id=<?php echo ($lapsic_user->id); ?>&filter=timers"><?php echo ($lapsic_user->timing); ?></a></p>
                    </div>
                </div>
                <div class="img-profilo-dettaglio">
                    <a href="profile.php?id=<?php echo($lapsic_user->id); ?>" class="nounderline">
                        <img src="media/avatar/<?php echo ( ( (isset($lapsic_user->img) && $lapsic_user->img != '') ? $lapsic_user->img : 'avatar.png') ); ?>" alt=""/>
                    </a>
                </div>
            </div>
        </div>
        <?php } ?>
            <div class="spacer-slider-blocchi-profile">
            <ul>
                <a href="profile.php?id=<?php echo($lapsic_user->id); ?>" class="nounderline">
                    <li <?php echo ( (PAGE_NAME == 'PROFILE' ) ? 'style ="background-color:#5F9CCA;"' : '') ?>>
                        your account
                    </li>
                </a>
                <a href="index.php?mode=rank" class="nounderline">
                    <li <?php echo ((isset($mode) && $mode == '' && PAGE_NAME == 'INDEX') ? 'style ="background-color:#5F9CCA;"' : '') ?>>
                        The best on lapsic
                    </li>
                </a>
                <a class="nounderline add-photo fancybox.ajax" href="/add-photo.php" data-fancybox-type="ajax">
                    <li>
                        add new pics
                    </li>
                </a>
            </ul>
</div>
        <!-- HEADER NEW HOME LOGGATO -->
    
<?php } ?>
<!-- COOKIE -->
<?php 

if (!(isset($_COOKIE['consensoCookies']) && $_COOKIE['consensoCookies']))
{
	$_SESSION['consensoCookiesSessione'] = 1;	
?>
<style type="text/css">
.box-info-cookie{ background: rgba(107, 184, 241, 0.9);width:100%; position:fixed; top:0; left:0; z-index:99999;}
.int-info-cookie{ width:960px; margin:auto; overflow:hidden; padding-top:15px; padding-bottom:15px;}
.txt-informativa-descr{ font-size:13px; float:left; width:760px; padding-left:18px; padding-top:8px; font-family: 'GothamBook';color:#FFF; padding-right:10px;}
.txt-informativa-descr a{  color:#FFF; }
.button-continua-informativa{ float:left; width:106px; border-radius:15px; background-color:#333333; height:34px; text-align:center; color:#000;   font-family: 'GothamMedium';  font-size:15px; line-height:34px; text-transform:uppercase; }
.button-continua-informativa a{  color:#FFF; text-decoration:none; display:block;}

@media (max-width:960px)
{
	.int-info-cookie{ width:100%;}
	.txt-informativa-descr{ width:90%; margin:auto; float:none; font-size:11px; text-align:center; padding:0; padding-top:8px;}
	.button-continua-informativa{ float:none; margin:auto; margin-top:10px; font-size:13px;}
}

</style>

 <!-- banner COOKIE-->     
<div class="box-info-cookie">
	<div class="int-info-cookie">
    <div class="txt-informativa-descr">
     Il presente sito web si avvale dei cookie. Proseguendo nella navigazione si accetta implicitamente il loro utilizzo.  <a href="cookies.php" >Informativa estesa</a> .
 
    </div>
    <div class="button-continua-informativa">
    	<a href="javascript:void(0);" onClick="javascript:setConsensoCookies();">continua</a>
    </div>
  </div>
</div>
<script>
function setConsensoCookies()
{
  var scadenza = new Date();
  var adesso = new Date();
  scadenza.setTime(adesso.getTime() + (365 * 24 * 60 * 60000));
  document.cookie = 'consensoCookies=1; expires=' + scadenza.toGMTString() + '; path=/';
  $('.box-info-cookie').slideToggle();
}
</script>
<!-- COOKIE -->
<?php 
}
?>
  