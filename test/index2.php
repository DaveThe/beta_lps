<?php
session_start();

?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | Benvenuti</title>
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
	$(document).ready(function() {
		console.log($(window).width());
		console.log($(window).height());
		$(".add-photo").fancybox({
			autoSize        :  false,
			padding       : '1',
			margin      : '2',
			autoScale     : false,
			width         : '100%',
			height       : '100%',
			type          : 'iframe',
			closeBtn        : false,
			iframe : {
			   scrolling : 'no'
			}
		 });
		 
		 $('.box-login-home').click(function() {
      $('.content-form-login').slideToggle(700);
    });
		
		
		
    $('.cont-slider').flexslider({
		animation: "slide",
		animationLoop: true,
		directionNav: true,
		controlNav: false,
		itemWidth: 0,
		itemMargin : 0,
		
 		controlsContainer: ".flex-container",
          start: function(slider) {
            $('.total-slides').text(slider.count);
						$('.current-slide').text(slider.currentSlide + 1);
          },
          after: function(slider) {
            $('.current-slide').text(slider.currentSlide + 1);
          }		
		});
		
		/*var h_box_login = $('#accedi').height();
		$('.box-left-form-login').css('min-height', h_box_login);*/
		
		
	});
</script>
<style type="text/css">
.header-int{ max-width:1394px;}
</style>
</head>

<body>
<?php include('include/googanal.php'); ?>

<!-- BOX CERCA  -->
<?php include('include/box-cerca.php'); ?>
<!-- BOX CERCA  -->

<!-- BOX ADD PHOTO  -->
<?php include('include/add-photo.php'); ?>
<!-- BOX ADD PHOTO  -->

<!-- BOX DETTAGLIO FOTO  -->
<?php include('include/dettaglio-photo.php'); ?>
<!-- BOX DETTAGLIO FOTO  -->

<div class="second-container">


	<?php /*include ("include/header.php");*/?>
  
  
  <!-- HEADER NEW HOME NO LOGGATO -->
    <div class="box-ico-cerca-notifica">
  	<img src="images/ico-notifica.png" width="56" alt=""/>
    <img src="images/ico-cerca.png" width="56" id="search" alt=""/>
  </div>
  <div class="box-profilo">
  	<a href="profilo-utenti.php"><img src="images/profilo.png" width="20" height="109" alt=""/></a>
  </div>

  
	<div class="logo-home-center">
  	<img src="images/logo.png" class="img-logo" alt=""/>
  </div>
  <div class="txt-intro-home">
  	Lorem ipsum sit amet, consectur elit
  </div>
  <div class="box-login-home">
   LOGIN
  </div>
  <div class="content-form-login">
  	<div class="content-int-form-login">
    	<div class="box-left-form-login" id="accedi">
      	<input type="text" class="input-login" placeholder="nome utente"/>
      	<input type="password" class="input-login" placeholder="password" />
      	<button type="submit" class="button-login">accedi</button>
      </div>
    	<div class="box-left-form-login">
      	<p class="accedi-con-txt">accedi con</p>
        <div class="box-social-login">
          <img src="images/fb_social_log.png" width="30" alt=""/>
          <img src="images/goog_plus_social.png" width="30" alt=""/>
        </div>
      </div>
    	<div class="box-left-form-login">
      	<p class="accedi-con-txt">non sei ancora<br /> registrato?</p>
      	<div class="button-login"><a href="#">registrati</a></div>
      </div>
    </div>
  </div>
  
  <!-- HEADER NEW HOME NO LOGGATO -->
  
  
  <div class="container-menu-e-blocchi">
  	
    
    
  <!--Slider -->
  <div class="box-cont-slider">
    <div class="cont-slider">
        <ul class="slides">
          <li style="background:url(images/slider/001.jpg);" class="img-slider">
            <div class="box-dida-slider">
              Lorem ipsum sit amet, consectur elit lorem ipsum sit amet, elit
              <span>pic by Alessandro Bianchi</span>
            </div>
          </li>
          <li style="background:url(images/slider/002.jpg);" class="img-slider">
            <div class="box-dida-slider">
              Lorem ipsum sit amet, consectur elit lorem ipsum sit amet, elit
              <span>pic by Alessandro Bianchi</span>
            </div>
          </li>
          <li style="background:url(images/slider/003.jpg);" class="img-slider">
            <div class="box-dida-slider">
              Lorem ipsum sit amet, consectur elit lorem ipsum sit amet, elit
              <span>pic by Alessandro Bianchi</span>
            </div>
          </li>
          <li style="background:url(images/slider/004.jpg);" class="img-slider">
            <div class="box-dida-slider">
              Lorem ipsum sit amet, consectur elit lorem ipsum sit amet, elit
              <span>pic by Alessandro Bianchi</span>
            </div>
          </li>
          <li style="background:url(images/slider/005.jpg);" class="img-slider">
            <div class="box-dida-slider">
              Lorem ipsum sit amet, consectur elit lorem ipsum sit amet, elit
              <span>pic by Alessandro Bianchi</span>
            </div>
          </li>
        </ul>
    </div>
  </div>
  <!--Slider -->
    
    
    
  	<!--navigation blocchi -->
  	<div class="spacer-slider-blocchi">
    	<ul>
        <li>
          best on lapsic
        </li>
        <?php /*?><li>
          best on lapsic
        </li><?php */?>
      </ul>
    </div>
  	<!--navigation blocchi -->
    
    <?php /*?>
			MENU OLD
		<div class="menu-blocchi">
    	<p>what’s new</p>
    	<p>timing’s best</p>
    	<p>best on lapsic</p>
      
    </div><?php */?>
    
    <div id="container-blocchi">
      
	<div class="item">
      	<img class="img-zoom" src="images/isotope/001.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/002.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/003.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/004.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/005.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/006.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/007.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/008.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/001.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/002.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/003.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/004.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/005.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/006.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/007.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/008.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/001.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/002.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/003.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/004.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/005.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/006.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/007.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/008.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/001.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/002.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/003.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/004.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/005.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/006.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/007.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/008.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/001.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/002.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/003.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/004.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/005.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/006.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/007.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>
    	<div class="item">
      	<img class="img-zoom" src="images/isotope/008.jpeg" width="100%" alt=""/>
        <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt=""/>
        <div class="box-date-hour">
        	<div class="date-item">
          	112d:04h
         </div>
         <div class="add-hour">
         +24 h
         </div>
        </div>
      	<div class="name-profile-photo">
        	Giacomo
					<span>#27</span>
        </div>
      </div>      
      <div class="box-scroll-and-add">
        <img src="images/add-image.png" width="52" class="add-photo" alt=""/><br />
      	<img src="images/scrolltop.png" width="52" id="scroll-top" alt=""/>
      </div>
    </div>
    
  </div>
</div>


</body>
</html>
