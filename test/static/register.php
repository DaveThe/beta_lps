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
//include_once(dirname(__FILE__).'/config/config.php');

//include_once('super.php'); 
//include_once('check_login.php');
$err = true;
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | Register</title>
<?php include_once('include/resources.php'); ?>
<script>var lapsic_login = <?php echo ( (isset($_SESSION['lapsic_login']) && $_SESSION['lapsic_login'] != '' && $_SESSION['lapsic_login'] == true) ?'true' : 'false' ); ?>;</script>
<script type="text/javascript" src="js/register.js" defer></script>
<script type="text/javascript" defer>
var MIN_LENGTH = 3;
function CheckNickname()
{
    var keyword = $("#nickname").val();
    
    //console.log('inizio ricerca con la parola: '+keyword);
    
	if (keyword.length >= MIN_LENGTH) {
	   $.ajax({
            url: 'include/CheckNickname.php',  //Server script to process data
            type: 'GET',
            //Ajax events
            beforeSend: beforeSendHandler,
            success: completeHandler,
            error: errorHandler,
            // Form data
            data: 'text='+keyword,
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false,
            contentType: false,
            processData: false
        });
        
        function beforeSendHandler(e)
        {
            //console.log(' ---beforeSendHandler-- ');
            $("#loadin").show();
            //console.log(e);
            $("#nickname").css('border','2px solid green');
            $('#nickname_label').html('<img id="loadin" style="display: none;" src="http://i.stack.imgur.com/FhHRx.gif" />Nickname');
        }
        function completeHandler(data)
        {
            //console.log(' ---completeHandler-- ');
            //console.log(data);
            var objJson = JSON.parse(data);
            //console.log(objJson.count);
            if(objJson.count > 0)
            {
                $("#nickname").css('border','2px solid red');
                $('#nickname_label').html('<img id="loadin" style="display: none;" src="http://i.stack.imgur.com/FhHRx.gif" />Nickname already in use');
            }
            $("#loadin").hide();
        }
        function errorHandler(e)
        {
            $("#nickname").css('border','2px solid red');
            //console.log(' ---errorHandler-- ');
            //console.log(e);
        }
	} 
}


$(document).ready(function() {
    
	$("#nickname").keyup(function() {
        //CheckNickname();
    });
    
});

</script>
<style type="text/css">
.label-box{font-family: 'GothamBook'; color: #FFF; font-size: 18px; padding-bottom: 5px;}

.wid50{ width:50%;}

@media (max-width:480px)
{
.box-form-modifica-profilo{ width:94%; }
.wid50{ width:100%; padding-top:10px;}
.dis_block_mob{ display:block; float:none;}
}
</style>
</head>
<body>
<div class="container-add-photo">
 <div class="content-add-photo">
 	<div class="button-chiudi">
  	chiudi <span>x</span>
  </div>
  <div class="contenitore-box-add-photo pdBt28">
	<div class="txt-add-photo" style="text-align: center;">
    	JOIN LAPSIC AND DISCOVER HOW LONG YOUR PICTURES CAN SURVIVE THE TIME
    </div><?php /*target="_top"*/ ?>
    <form method="post" action="register.php" id="root_form">
        <input type="hidden" name="act" value="register" />
            
            <div class="box-form-modifica-profilo" style="width: 97%;">
                <?php if(sizeof($errors)>0) $err = true; ?>                    
                <div class="spacer-modifica-profilo"></div>
                <label class="fln label-box">E-mail <?php echo ( (isset($errors) &&( $err && ( isset($errors['email']) && $errors['email'] != '' ) )) ? '<span style="color:red;">- Inserisci una mail valida</span>' : '' ); ?></label>       
                <input type="text" class="fln" style="width: 94%;<?php echo ( (isset($errors) &&( $err && ( isset($errors['email']) && $errors['email'] != ''))) ? '    border: 2px solid red;' : '' ); ?>" placeholder="Email" id="email" name="email"  value="<?php echo(isset($lapsic_user->email)? $lapsic_user->email :''); ?>"/>
                
                <div class="spacer-modifica-profilo"></div>
                <label id="nickname_label" class="fln label-box"><img id="loadin" style="display: none;" src="http://i.stack.imgur.com/FhHRx.gif" />Nickname <?php echo ( (isset($errors) &&( $err && ( isset($errors['nickname']) && $errors['nickname'] != ''))) ? '<span style="color:red;">- Inserisci un nickname</span>' : '' ); ?></label>
                <input type="text" class="fln" style="width: 94%;<?php echo ( (isset($errors) &&( $err && ( isset($errors['nickname']) && $errors['nickname'] != ''))) ? '    border: 2px solid red;' : '' ); ?>" placeholder="Nickname" id="nickname" name="nickname"  value="<?php echo(isset($lapsic_user->nickname)? $lapsic_user->nickname :''); ?>"/>       
                
                <div class="spacer-modifica-profilo"></div>
                <label class="fln label-box">Password<?php echo ( (isset($errors) &&( $err && ( isset($errors['password']) && $errors['password'] != ''))) ? '<span style="color:red;">- '.$errors['password'].'</span>' : '' ); ?></label>
                <input type="password" class="fln" style="width: 94%;<?php echo ( (isset($errors) &&( $err && ( isset($errors['password']) && $errors['password'] != ''))) ? '    border: 2px solid red;' : '' ); ?>" placeholder="Password" id="password_register" name="password" value="<?php echo(isset($lapsic_user->password)? $sec->decript(base64_decode($lapsic_user->password) ) :''); ?>" >
                <label class="fln label-box">Confirm password<?php echo ( (isset($errors) &&( $err && ( isset($errors['password2']) && $errors['password2'] != ''))) ? '<span style="color:red;">- '.$errors['password2'].'</span>' : '' ); ?></label>
                <input type="password" class="fln" style="width: 94%;<?php echo ( (isset($errors) &&( $err && ( isset($errors['password2']) && $errors['password2'] != '' ) )) ? '    border: 2px solid red;' : '' ); ?>" placeholder="Confirm Password" id="conferma_password" name="conferma_password" value="<?php echo(isset($lapsic_user->password)? $sec->decript(base64_decode($lapsic_user->password) ) :''); ?>" >
                
                <div class="spacer-modifica-profilo"></div>
                
            			
                <button type="submit" class="button-salva-modifiche">Register</button>
            </div>
            
    </form>
  </div>
 </div>
</div>

</body>
</html>