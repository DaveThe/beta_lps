
<style type="text/css">
		#footer{ position:fixed; width:100%; bottom:0; left:0; padding:10px 0; background-color:#6bb8f1;}
		.footer-int{ width:90%; margin:auto; position:relative; text-align:center; font-family: 'GothamBook'; font-size:12px; color:#FFF;}
		.term-conditions{ position:absolute; right:0; top:0; text-transform:uppercase;}
		.footer-int a{  color:#FFF; text-decoration:none;}
		.term-conditions a{ color:#FFF; text-decoration:none; }
		@media(max-width:767px)
		{
			.footer-int{ text-align:left;}
			.term-conditions{ position:static; padding-top:10px; }
		}
	</style>

<div id="footer">
    <div class="footer-int">
        Lapsic.it 2015 &reg;
        <div class="term-conditions">
            <g:plusone size="small"></g:plusone> | <a href="http://test.lapsic.it/include/terms.php" id="popup_term">terms and conditions</a> | <a href="about.php" id="popup_term">About</a><?php if(isset($_SESSION['lapsic_login']) && $_SESSION['lapsic_login']==true) { ?><a href="index.php?exit=1"> | logout</a> <?php } ?>
        </div>
    </div>
</div>

<?php if((!isset($_SESSION['lapsic_logged']) || $_SESSION['lapsic_logged'] == false) && MODE != 'LOCALE') { 
 
?>
    <?php /*****PARTE JAVASCRIPT PER FB e GOOGLE*****/ ?>
    <?php //Social::getInstance()->generaJs('GO', (isset($_SESSION['state'])? $_SESSION['state'] :'')); ?>
    <?php //Social::getInstance()->generaJs('FB', (isset($_SESSION['state'])? $_SESSION['state'] :'')); ?>
    <?php $teeee->generaJs('GO', (isset($_SESSION['state'])? $_SESSION['state'] :'')); ?>
    <?php $teeee->generaJs('FB', (isset($_SESSION['state'])? $_SESSION['state'] :'')); ?>
    
<?php } ?>