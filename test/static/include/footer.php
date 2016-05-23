
<style type="text/css">
		#footer{ position:fixed; width:100%; bottom:0; left:0; padding:10px 0; background-color:#6bb8f1;}
		.footer-int{ width:90%; margin:auto; position:relative; text-align:center; font-family: 'GothamBook'; font-size:12px; color:#FFF;}
		.term-conditions{ position:absolute; right:0; top:0; text-transform:uppercase;}
		.footer-int a{  color:#FFF; text-decoration:none;}
		.term-conditions a{ color:#FFF; text-decoration:none; }
		@media(max-width:767px)
		{
		.footer-int{ text-align:left;}
		}
	</style>

<div id="footer">
    <div class="footer-int">
        Lapsic.it 2015 &reg;
        <div class="term-conditions">
            <a href="http://test.lapsic.it/include/terms.php" id="popup_term">terms and conditions</a> | About<?php if(isset($_SESSION['lapsic_login']) && $_SESSION['lapsic_login']==true) { ?><a href="index.php?exit=1"> | logout</a> <?php } ?>
        </div>
    </div>
</div>
