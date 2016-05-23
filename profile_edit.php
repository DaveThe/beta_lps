<?php
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
$sec		= new Lapsic\Secret();
include_once(dirname(__FILE__).'/config/class/MagicUpload/index.php');
$err = false;

if(isset($_POST["act"]) && $_POST["act"]=='profile') {
	$res = false;
    
	if(isset($_POST['username']) && trim($_POST['username'])!=''){
		$lapsic_user->username =  $_POST['username'];
	}
    
    if(isset($_POST['password']) && trim($_POST['password'])!='' && preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $_POST['password']))
    {
		//if(isset($_POST['conferma_password']) && $_POST['password']==$_POST['conferma_password']){
			$lapsic_user->password =  $_POST['password'];
		/*
        }
        else
        {
			$errors['password2'] = "Le password non coincidono";
		}
        */
	}
	else 
    {
		$errors['password'] = "Devi inserire una password compresa tra gli 8 e i 20 caratteri, con una maiuscola e un numero";
        $errors['password2'] = $errors['password'];
	}

	if(isset($_POST['nickname']) && trim($_POST['nickname'])!=''){
		$lapsic_user->nickname 			=  $_POST['nickname'];
	}
    else
    {
        $errors['nickname'] = "Devi inserire il tuo nickname";
    }
	
	if(isset($_POST['name']) && trim($_POST['name'])!='')
    {
		$lapsic_user->name 			=  $_POST['name'];
	}
	
	if(isset($_POST['surname']) && trim($_POST['surname'])!='')
    {
		$lapsic_user->surname 			=  $_POST['surname'];
	}
      
	if(isset($_POST['email']) && trim($_POST['email'])!='' && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
		$lapsic_user->email 			=  $_POST['email'];
	}
	else
	{	
		$errors['email'] 					= "Devi inserire una Mail valida";
	}
    
    if(isset($_POST['gender']) && trim($_POST['gender']) != '')
    {
	   $lapsic_user->gender 				    = $_POST['gender'];	
	}
	else
	{	
		$errors[] 					= "Devi dirmi se sei Uomo o Donna o altro";
	}
    
	if(isset($_POST['avatar']) && trim($_POST['avatar']) != '')
    {
	   $lapsic_user->img 				    = $_POST['avatar'];	
	}
	else
	{	
        if($lapsic_user->gender == 0 )
        {
            $lapsic_user->img                = 'avatar5.png';
        }
        else if($lapsic_user->gender == 1)
        {
            $lapsic_user->img                = 'avatar3.png';
        }
        else
        {
            $lapsic_user->img                = 'avatar2.png';
        }
		
	}
	
	if(isset($_POST['country']) && trim($_POST['country'])!=''){
		$lapsic_user->country 					=  $_POST['country'];
	}
	
	if(isset($_POST['city']) && trim($_POST['city'])!=''){
		$lapsic_user->city 					=  $_POST['city'];
	}
    
	if(isset($_POST['state']) && trim($_POST['state'])!=''){
		$lapsic_user->state 					=  $_POST['state'];
	}
	    
	if(isset($_POST['note']) && trim($_POST['note'])!=''){
		$lapsic_user->note 					=  $_POST['note'];
	}
    

	if(isset($_POST['informativa']) && trim($_POST['informativa'])!='')
    {
		$lapsic_user->informativa		=  '1';
	}
	else
	{	
		$errors['informativa']			= "Devi accettare l'informativa";
	}
    
	if(sizeof($errors)==0) 
    {	   
        $lapsic_user->status = '1';
        $ret = false;
		$res = $lapsic_user->Update();
		if($res) 
        {
			$resp_code 			= 110;
            
            $action     = new Lapsic\LogAction($db, UPDATE, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG, 'Aggiornamento dati utente #'.$lapsic_user->id);                            
            $ret		= $action->Insert();
			
		} 
        else 
        {
			$resp_code 			= 115;	
		}

		if($ret) 
        {
			header('Location: profile_edit.php?resp_code='.$resp_code);// /user/'.$lapsic_user->id.'/edit/notice/'.$resp_code);
			exit ();
		} else {
			$resp_code 				= 635;
		}
	}
}
if($lapsic_user->status == '2')
{
    $errors['password'] = "Devi inserire una password compresa tra gli 8 e i 20 caratteri, con una maiuscola e un numero";
    $errors['password2'] = $errors['password'];
}

?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | Profile</title>
<?php include_once('include/resources.php'); ?>
<script type="text/javascript">

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
        CheckNickname();
    });
    
});

</script>
<style type="text/css">
.label-box{font-family: 'GothamBook'; color: #FFF; font-size: 18px; padding-bottom: 5px;}
.button-cyan-edit, .box-add-txt-photo-edit{ text-align:left; max-width:203px; padding-left:10px; display:block; float:none; clear:both;}
.button-cyan-edit{max-width:208px;}
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
<?php include('include/googanal.php'); ?>

<div class="second-container">

	<?php include ("include/header.php");?>
  
  <div class="content-profilo">
  <?php if(sizeof($errors)>0) $err = true; ?>
    <div class="box-title-edit-photo">
    	<p>EDIT PROFILE <?php echo(($resp_code=='12') ? '<span style="color:red;">PLEASE COMPLETE THIS FORM AND START TO SHARE YOUR PHOTO!</span>':'' ); ?><?php echo(($resp_code=='110') ? '<span style="color:#8BFB8B;"> - THANK YOU!</span>':'' ); ?></p>
    </div>
    <div class="box-edit-photo">
                
        <form method="post" action="profile_edit.php"> <!--/user/<?php echo($lapsic_user->id); ?>/edit">-->
			<input type="hidden" name="act" value="profile" />
            <?php /*
            <div class="MKU_AVATARS" id="avatar"><input type="hidden" id="source_name" value="<?php echo (isset($lapsic_user->img) ? $lapsic_user->img : ''); ?>" /></div>
            */ ?>
            <div class="box-txt-edit-photo">
             
                <div class="img-profilo-modifica">
                               </div>
            </div>
            <div class="box-form-modifica-profilo">
            
            
                <div class="left wid50">    
                    <label class="lf label-box">Username</label>
                    <input type="text" class="lf" placeholder="username" id="username" name="username" value="<?php echo(isset($lapsic_user->username)?$lapsic_user->username:''); ?>" />
                </div>
                
                <div class="right wid50">
                    <label id="nickname_label" class="lf label-box"><img id="loadin" style="display: none;" src="http://i.stack.imgur.com/FhHRx.gif" />Nickname <?php echo ( (isset($errors) &&( $err && ( isset($errors['nickname']) && $errors['nickname'] != ''))) ? '<span style="color:red;">- Inserisci un nickname</span>' : '' ); ?></label>
                    <input type="text" class="rt" placeholder="Nickname" id="nickname" name="nickname" value="<?php echo((isset($lapsic_user->nickname) || $lapsic_user->nickname != 'NULL')?$lapsic_user->nickname:''); ?>"  readonly="<?php echo((isset($lapsic_user->nickname) || $lapsic_user->nickname != 'NULL')?true:false); ?>" />
                </div>
                    
                <div class="spacer-modifica-profilo"></div>
                
                <div class="left wid50">    
                    <label class="lf label-box">Name</label>
                    <input type="text" class="lf" placeholder="name" id="name" name="name" value="<?php echo(isset($lapsic_user->name)?$lapsic_user->name:''); ?>" />
                </div>
                
                <div class="right wid50">
                    <label class="lf label-box">Surname</label>
                  	<input type="text" class="rt" placeholder="surname" id="surname" name="surname" value="<?php echo(isset($lapsic_user->surname)?$lapsic_user->surname:''); ?>" />
                </div>
                    
                    <div class="spacer-modifica-profilo"></div>
                    <label class="fln label-box" style="display:block; clear:both;">Address or City</label>
                    <input type="text" class="fln" style="width: 97%;" placeholder="Enter your address" id="autocomplete" onFocus="geolocate()" value="<?php echo($lapsic_user->country.' '.$lapsic_user->state.' '.$lapsic_user->city); ?>" />        
                
                    <label class="fln label-box"></label>
                    <input type="text" class="fln" placeholder="city" id="locality" name="city" value="<?php echo(isset($lapsic_user->city)?$lapsic_user->city:''); ?>"/>
                    <input type="text" class="fln" placeholder="state" id="administrative_area_level_1" name="state" value="<?php echo(isset($lapsic_user->state)?$lapsic_user->state:''); ?>"/>
                    <input type="text" class="fln" placeholder="country" id="country" name="country" value="<?php echo(isset($lapsic_user->country)?$lapsic_user->country:''); ?>"/>
                    
                    <div class="spacer-modifica-profilo"></div>
                  	<?php /* <input type="text" placeholder="data di nascita" /> */ ?>
                    <label class="fln label-box">Gender</label>
                	<select class="fln" id="gender" name="gender">
                		<option value="0" <?php echo ( ( isset($lapsic_user->gender) && $lapsic_user->gender == '0' ) ? 'selected="selected"': '' ); ?>>Uomo</option>
                		<option value="1" <?php echo ( ( isset($lapsic_user->gender) && $lapsic_user->gender == '1' ) ? 'selected="selected"': '' ); ?>>Donna</option>
                	</select> 
                    
                    
                    <div class="spacer-modifica-profilo"></div>
                    <label class="fln label-box">E-mail <?php echo ( (isset($errors) &&( $err && ( isset($errors['email']) && $errors['email'] != '' ) )) ? '<span style="color:red;">- Inserisci una mail valida</span>' : '' ); ?></label>       
                    <input type="text" class="fln" placeholder="e-mail" id="email" name="email" readonly  value="<?php echo(isset($lapsic_user->email)?$lapsic_user->email:''); ?>"/>
                      <?php /*
                  	<input type="text" class="fln" placeholder="Confirm e-mail" />
                    */ ?>
                    
                    <div class="spacer-modifica-profilo"></div>
                    <label class="fln label-box">Password<?php echo ( ((!isset($lapsic_user->password) || $lapsic_user->password == '') || (isset($errors) &&( $err && ( isset($errors['password']) && $errors['password'] != ''))) ) ? '<span style="color:red;">- '.$errors['password'].'</span>' : '' ); ?></label>
                    <input type="password" class="fln" placeholder="Password" id="password" name="password" value="<?php echo((isset($lapsic_user->password) && $lapsic_user->password != '')? $sec->decript(base64_decode($lapsic_user->password) ) :''); ?>" >
                    <?php /*
                    <label class="fln label-box">Confirm password<?php echo ( ((!isset($lapsic_user->password) || $lapsic_user->password == '') || (isset($errors) &&( $err && ( isset($errors['password2']) && $errors['password2'] != ''))) ) ? '<span style="color:red;">- '.$errors['password2'].'</span>' : '' ); ?></label>
                    <input type="password" class="fln" placeholder="Confirm Password" id="conferma_password" name="conferma_password" value="<?php echo((isset($lapsic_user->password) && $lapsic_user->password != '')? $sec->decript(base64_decode($lapsic_user->password) ) :''); ?>" >
                    */ ?>
                    <div class="spacer-modifica-profilo"></div>
                    
                  	<div class="button-cyan-edit">
                    	descriviti >>
                    </div>
                    <textarea class="box-add-txt-photo-edit" id="note" name="note"><?php echo(isset($lapsic_user->note)?$lapsic_user->note:''); ?></textarea>
                
                    <div class="spacer-modifica-profilo"></div>
                    
                    <input type="checkbox" id="informativa" name="informativa" <?php echo((isset($lapsic_user->informativa) && $lapsic_user->informativa != '') ? 'checked' : ''); ?> > <span class="informativa-privacy" <?php echo ( (isset($errors) &&( $err && ( isset($errors['informativa']) && $errors['informativa'] != ''))) ? 'style="color:red;"' : '' ); ?> >Accetto l'informativa privacy</span>
                
                    <div class="spacer-modifica-profilo"></div>
                			
                    <button type="submit" class="button-salva-modifiche">salva modifiche</button>
            
            </div>
        </form>
    </div>
  </div>
</div>
    <?php include ("include/footer.php");?>
<?php
include_once(dirname(__FILE__).'/config/class/MagicUpload/script.php');
?>

</body>
</html>
