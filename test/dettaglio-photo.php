
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | Add Photo</title>
<link rel="stylesheet" type="text/css" href="css/reset-all.css">
<link rel="stylesheet" type="text/css" href="css/flexslider.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/common.css">
<link rel="stylesheet" type="text/css" href="js/fancy/jquery.fancybox.css">


<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="js/jquery.transform.js"></script>
<script type="text/javascript" src="js/jquery-animate-css-rotate-scale.js"></script>
<script type="text/javascript" src="js/fancy/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="js/isotope.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/parallax.js"></script>
<script type="text/javascript" src="js/countdown.js"></script>
<script type="text/javascript" src="js/jquery-ias.min.js"></script>
<script type="text/javascript" src="js/jquery.lazy.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!-- FastClick -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min.js'></script>
<!-- SlimScroll 1.3.0 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.3/jquery.slimscroll.min.js" type="text/javascript" defer></script>
<script type="text/javascript">

$(document).ready(function(e) {
	$('.button-chiudi').click(function(){
	console.log('chiudi');
	//parent.$.fancybox.close();
    try{
        parent.jQuery.fancybox.close();
    }catch(err){
        parent.$('#fancybox-overlay').hide();
        parent.$('#fancybox-wrap').hide();
    }
});
    
});


</script>
</head>
<body>
    <div class="container-dett-img">
      <!-- apre pagina dettaglio img -->
    </div>
</body>
</html>

