<?php 
    namespace Lapsic;
    /*
    $ParametersList['pagination']   = false;
    $ParametersList['status']       = '0';
    $ParametersList['own_element']  = $lapsic_user->id;
    $notify                         = LapsicNotification::GetElementsList($ParametersList);
    */ 
    $errors = array(1,2);
?>
  
    
    <?php /*if(isset($_SESSION['lapsic_logged']) && $_SESSION['lapsic_logged']) { ?>
        <div class="box-ico-cerca-notifica">
            <!-- <img src="images/ico-notifica.png" width="56" alt=""/> -->
            <a class="box-cerca fancybox.ajax" href="/box-cerca.php" data-fancybox-type="ajax"><img src="images/ico-cerca.png" width="56" id="search" alt=""/></a>
        </div>
        <div class="box-profilo">
            <a href="profile.php"><img src="images/profilo.png" width="20" height="109" alt=""/></a>
        </div>
    <?php }*/ ?>
    
   
    <?php //if(!isset($_SESSION['lapsic_logged']) || $_SESSION['lapsic_logged'] == false) { 
            if(true){ ?>
        <!-- HEADER NEW HOME NO LOGGATO -->
        <?php //var_dump($errors); ?>
        <!-- LOGO SEMPRE PRESENTE -->
        <div class="logo-home-center">
            <a href="index.php"><img src="images/logo.png" class="img-logo" alt=""/></a>
        </div>
        <div class="txt-intro-home">
            HYPE SENSITIVE PHOTOGRAPHY – WHICH PICS WILL STAND THE TEST OF TIME?
        </div>
        <?php
        //if(sizeof($errors)>0)
        //{
        ?>
            <div class="txt-intro-home" style="color: red !important;">
                Login errato STESSO DISCORSO DEL RETTANGOLO PER LE NOTIFICHE NEGATIVE E POSITIVE
            </div>
        <?php //} ?>
        <div class="box-login-home">
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
                        //Social::getInstance()->generaBottone('FB', '<img src="images/fb_social_log.png" width="30" alt="" style="cursor: pointer;"/>');
                        //Social::getInstance()->generaBottone('GO', '<img src="images/goog_plus_social.png" width="30" alt="" style="cursor: pointer;"/>'); 
                        
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
    
        <div class="box-ico-cerca-notifica">
          <a class="box-cerca fancybox.ajax" href="/box-cerca.php" data-fancybox-type="ajax"><img src="images/ico-cerca.png" width="28" id="search" alt=""/></a>
        </div>
        <div class="logo-home-center" style="padding-top: 10px;">
          <a href="index.php"><img src="images/logo.png" class="img-logo" alt=""/></a>
        </div>
        <div class="txt-intro-home" style="text-transform: uppercase;"> 
                JOIN LAPSIC AND DISCOVER HOW LONG YOUR PICTURES CAN SURVIVE THE TIME
            <?php /* JOIN LAPSIC AND DISCOVER HOW LONG YOUR PICTURES CAN SURVIVE THE TIME */
                /*
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
                */
            ?>
        </div>
        <div class="box-abs-what-and-time">
        	<ul>
          	<li > <a href="index.php?mode=new" class="nounderline">what's new</a></li>
          	<li style ="background-color:#5F9CCA;" > <a href="index.php?mode=timers" class="nounderline">timing's best</a></li>
          </ul>
        </div>
        <?php //if( ( PAGE_NAME == 'PROFILE' && !$my_profile) || ( PAGE_NAME != 'PROFILE') ) { ?>
        <div class="box-profilo-header">
            <div class="box-dettaglio-profilo">
                <div class="box-numeri-profilo">
                    <div class="numeri-profilo-left">
                        <p class="nome-profilo-dett">lorem ipsum dolor sit amet lorem ipsum dolor sit amet</p>
                        <p class="time-profilo-dett"><a class="nounderline" href="profile.php">Timing</a></p>
                        <p class="time-profilo-dett"><a class="nounderline"  href="profile.php">Timers</a></p>
                    </div> 
                    <div class="numeri-profilo-right">
                        <p class="codice-utente">
                        #124524678657
                        </p>
                        <p class="time-profilo-numeri"><a class="nounderline" href="profile.php">14235456</a></p>
                        <p class="time-profilo-numeri"><a class="nounderline"  href="profile.php">524356</a></p>
                    </div>
                </div>
                <div class="img-profilo-dettaglio">
                    <a href="profile.php" class="nounderline">
                        <img src="media/avatar/avatar.png" alt=""/>
                    </a>
                </div>
            </div>
        </div>
        <?php } ?>
      	<div class="spacer-slider-blocchi-profile">
        	<ul>
            <li >
              <a href="profile.php" class="nounderline">your account</a>
            </li>
            <li >
              <a href="index.php?mode=rank" class="nounderline">The best on lapsic</a>
            </li>
            <li>
              <a class="nounderline add-photo fancybox.ajax" href="/add-photo.php" data-fancybox-type="ajax">add new pics</a>
            </li>
          </ul>
        </div>
        <!-- HEADER NEW HOME LOGGATO -->
    <?php //} ?>
  