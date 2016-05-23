<?php 
/*INCLUDE FACEBOOK*/
?>
<div id="fb-root"></div>
<script type="text/javascript">
window.fbAsyncInit = function() {
	FB.init({
		appId      : '<?php echo($s_login->getFBKey()); ?>',
		channelUrl : '<?php echo($_SERVER['PHP_SELF']); ?>/login_facebook_channel.htm',
		status     : false,
		cookie     : true,
		xfbml      : true,
		version    : 'v2.3' 
	});
};

(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/it_IT/all.js";
	ref.parentNode.insertBefore(js, ref);
}(document));
 
 
//Questa funzione chiama il popup di facebook e reindirizza sulla pagine dove viene effettuato il recupero dei dati 
function FBLogin() {
	FB.login(function(response) {
		if (response.authResponse) {
			FB.api('/me', function(response) {
				$.ajax({
				  method: "POST",
				  url: "login_social.php",
				  dataType: "json",
				  data: {state: "<?php echo($_SESSION['state']); ?>", t: 'FB'}
				})
				  .done(function( dati ) {
					if (dati.esito == 1)
					{
						document.getElementById('dati_utente').innerHTML = JSON.stringify(dati.data);
						//window.location.href = '/login_social.php';
					}
				  });

			});
		}
	},{scope: 'email'});
}

function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

//Questa funzione è per la condivisione di contenuti su facebook, non si sa mai potrebbe servire
function shareFB(ref){
	var share = {
		method: 'stream.share',
		u: ref
	};
	FB.ui(share, function(response) { 
		//console.log(response); 
	});
}
</script>