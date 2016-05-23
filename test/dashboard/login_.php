<?php 
include_once(dirname(__FILE__).'/config/config.php');

include_once('super.php');
//include_once('class_secret.php');  
include_once('check_login.php');

?>

<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!--<meta charset="UTF-8">-->
        <title><?php echo (NOME_PRJ); ?> | LOGIN</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
       <?php include_once(THEME.'/include/lib_js.php'); ?>
    </head>
	<!-- start logo 
	<div id="logo-login">
   <img src="images/logo.png" width="200" height="85" alt=""/>
	</div>
	 end logo -->
    <body class="bg-black">

        <div class="form-box" id="login-box">
			
			<?php if($respok !== false) include_once('alerts_callouts.php'); ?>
			<div class="header bg-black"><?php echo ( (isset($settings->logo) && $settings->logo != "" && file_exists('images/'.$settings->logo)) ? '<img src="'.'images/'.$settings->logo.'" width="225" height="70" border="0"  alt="Logo"/>' : $settings->titolo ); ?></div>
            
			<div class="header">Sign In</div>
			
            <form role="form" method="post">
                <div class="body bg-gray">
                    <div class="form-group <?php echo ( (sizeof($errors) > 0) ? 'has-error' : '' ); ?>">
						<?php if(sizeof($errors) > 0) { ?>
							<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> Input with error</label>
						<?php } ?>
                        <input type="text" name="utente" class="form-control" placeholder="User ID"/>
                    </div>
                    <div class="form-group <?php echo ( (sizeof($errors) > 0) ? 'has-error' : '' ); ?>">
						<?php if(sizeof($errors) > 0) { ?>
							<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> Input with error</label>
						<?php } ?>
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  
                    
                    <p><a href="#">I forgot my password</a></p>
                </div>
            </form>
        </div>

    </body>
</html>