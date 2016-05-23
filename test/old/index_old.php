<?php
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
<script type="text/javascript" src="js/fancy/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="js/isotope.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
</script>

<?php include('include/googanal.php'); ?>
</head>

<body>
<div class="container">

  <!--Header and Login -->
	<div class="header">
  	<a href="index.php"><img src="images/logo.png" class="img-logo" alt=""/></a>
    <div class="box-login-txt">
      LOGIN
    </div>
  </div>
  <div class="cont-login">
  	<div class="container-input">
    	<div class="box-label">
      	Username
     </div>
    	<div class="box-input">
      	<input type="text" />
     </div>
    	<div class="box-label">
      	Password
     </div>
    	<div class="box-input">
      	<input type="text" />
     </div>
     <p class="non-sei-reg">Non sei registrato? Clicca qui e inizia a donare</p>
    </div>
  </div>
  <p class="join-lapsic">Join lapsic and discover how long your pictures can survive the time</p>
  <!--Header and Login -->
  
  <!--Slider -->
  <div class="box-cont-slider">
    <div class="cont-slider">
        <ul class="slides">
          <li style="background:url(images/slider/001.jpg);" class="img-slider">
          	<div class="box-dida-slider">
            	<div class="name-dida-slider">
              	Kerg #10
             </div> 
            	<div class="hour-dida-slider">
              	130d:03h
             </div> 
           </div>
          </li>
          <li style="background:url(images/slider/002.jpg);" class="img-slider">
          	<div class="box-dida-slider">
            	<div class="name-dida-slider">
              	Kerg #10
             </div> 
            	<div class="hour-dida-slider">
              	130d:03h
             </div> 
           </div>
          </li>
          <li style="background:url(images/slider/003.jpg);" class="img-slider">
          	<div class="box-dida-slider">
            	<div class="name-dida-slider">
              	Kerg #10
             </div> 
            	<div class="hour-dida-slider">
              	130d:03h
             </div> 
           </div>
          </li>
          <li style="background:url(images/slider/004.jpg);" class="img-slider">
          	<div class="box-dida-slider">
            	<div class="name-dida-slider">
              	Kerg #10
             </div> 
            	<div class="hour-dida-slider">
              	130d:03h
             </div> 
           </div>
          </li>
          <li style="background:url(images/slider/005.jpg);" class="img-slider">
          	<div class="box-dida-slider">
            	<div class="name-dida-slider">
              	Kerg #10
             </div> 
            	<div class="hour-dida-slider">
              	130d:03h
             </div> 
           </div>
          </li>
        </ul>
    </div>
  </div>
  <!--Slider -->

  <div class="content-bottom-blocchi">
  
  	<!--navigation blocchi -->
  	<div class="spacer-sldier-blocchi">
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
    
  	<!--blocchi isotope -->
    <div id="container-blocchi">
    	<div class="item">
      	<img src="images/isotope/001.jpeg" width="100%" alt=""/>
      </div>
    	<div class="item">
      	<img src="images/isotope/002.jpeg" width="100%" alt=""/>
      </div>
    	<div class="item">
      	<img src="images/isotope/003.jpeg" width="100%" alt=""/>
      </div>
    	<div class="item">
      	<img src="images/isotope/004.jpeg" width="100%" alt=""/>
      </div>
    	<div class="item">
      	<img src="images/isotope/005.jpeg" width="100%" alt=""/>
      </div>
    	<div class="item">
      	<img src="images/isotope/006.jpeg" width="100%" alt=""/>
      </div>
    	<div class="item">
      	<img src="images/isotope/007.jpeg" width="100%" alt=""/>
      </div>
    	<div class="item">
      	<img src="images/isotope/008.jpeg" width="100%" alt=""/>
      </div>
    </div>
    <p class="join-lapsic pointer">show more</p>

    
  	<!--blocchi isotope -->
  </div>
  
	<div id="footer">
  	<div class="box-footer-left">
    	P.I. XXXXXXXXXXXXX Tutti i diritti riservati 2015
    </div>
  	<div class="box-footer-right">
    	about us | Termini e condizioni | privacy
    </div>
  </div> 
</div>

</body>
</html>
