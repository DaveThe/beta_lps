<?php 
/*INCLUDE GOOGLE*/
?>
<script type="text/javascript">
// Google login
var click_btn = false;

  (function() {
    var po = document.createElement('script');
    po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/client:plusone.js?onload=render';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(po, s);
  })();

function signinCallback(authResult) {
	//alert(authResult['code']);
  	if (click_btn && authResult['code']) {
		$.ajax({
		  method: "POST",
		  url: "login_social.php?storeToken",
		  dataType: "json",
		  data: { code: authResult['code'], state: "<?php echo($_SESSION['state']); ?>", t: 'GO'}
		})
		  .done(function( dati ) {
			if (dati.esito == 1)
			{
				document.getElementById('dati_utente').innerHTML = JSON.stringify(dati.data);
				//window.location.href = '/login_social.php';
			}
		  });

  } else if (authResult['error']) {

  }
}
function render() {
    gapi.signin.render('customBtn', {
      'callback': 'signinCallback',
      'clientid': '<?php echo($s_login->getGOKey()); ?>',
      'cookiepolicy': 'single_host_origin',
      'requestvisibleactions': 'http://schemas.google.com/AddActivity',
	  'accesstype': 'offline',
	  'approvalprompt' : 'force',
      'scope': 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email'
    });
  }

function clickBtn()
{
	click_btn = true;
}

</script>