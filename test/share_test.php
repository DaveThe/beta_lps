<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta property="fb:app_id" content="698255393636113">
<meta property="og:site_name" content="Facebook Developers">
<meta property="og:title" content="Facebook Content Sharing Best Practices - Documentazione - Facebook per gli sviluppatori">
<meta property="og:type" content="article">
<meta property="og:url" content="https://developers.facebook.com/docs/sharing/best-practices">
<meta property="og:image" content="https://static.xx.fbcdn.net/rsrc.php/v2/y6/r/YQEGe6GxI_M.png">
<meta property="og:locale" content="en_US">
<meta property="og:description" content="We want news sites, magazines, blogs, and other media sites to easily reach their existing fans and grow their fan base. This way, people can get the most engaging Facebook experience.">
<title>Documento senza titolo</title>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '698255393636113',
      xfbml      : true,
      version    : 'v2.4'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
   function shareFB(href)
   {
	   FB.ui({
		  method: 'share',
		  href: href,
		}, function(response){
			console.log(response);
			});
   }
</script>
</head>

<body>
<div style="background:#DD1115; color:#FFFFFF; width:150px; height:150px;" onClick="shareFB('http://lapsic.it/test/share_test.php');">
<span>Ciao Davide! Condividi!</span>
</div>
</body>
</html>
