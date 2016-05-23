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
<link href="upload.css'" rel="stylesheet" type="text/css" />


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
<!--
	<script src="<?php echo('/config/class/MagicUpload/core/js/lang.js'); ?>"></script>
	<script src="<?php echo('/config/class/MagicUpload/core/js/uploads.js'); ?>"></script>
-->

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
<div class="container-add-photo">
 <div class="content-add-photo">
 	<div class="button-chiudi">
  	chiudi <span>x</span>
  </div>
  <div class="contenitore-box-add-photo">
	<div class="txt-add-photo">
    	aggiungi le tue foto
    </div>
    <form method="post" action="edit_photo.php" id="root_form">
		<input type="hidden" name="act" value="upload_img" />
        
        <div>
			<div class="panel-body" id="upload">
				<!-- Standar Form -->
				<!-- <h4>Select files from your computer</h4> -->
				<form action="" method="post" enctype="multipart/form-data" id="upload_js-upload-form" class="js-upload-form">
					<!-- <div class="form-inline">      <div class="form-group">   -->
					<input type="file" name="files[]" id="js-upload-files" class="hidden" multiple="">
					<!--  </div>      <button type="submit" class="btn btn-sm btn-primary hidden" id="js-upload-submit">Upload files</button>    </div>  -->
					<!-- Drop Zone -->
					<!-- <h4>Or drag and drop files below</h4> -->
					<div class="upload-drop-zone" id="upload_drop-zone"><span class="text-msg">Just drag and drop files here</span></div>
					<!-- Progress Bar -->
					<div class="progress" id="upload_progress">
						<div class="progress-bar" id="upload_progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"> <span class="sr-only">0% Complete</span> </div>
					</div>
				</form>
				<!-- Upload Finished -->
				<div class="js-upload-finished" id="upload_js-upload-finished" style="display: none;">
					<h3>Processed files</h3>
                    <div class="list-group" id="upload_list_group">
                        <div class="box-photo-add-vuoto"><img style="height: 177px; width: 200px;" src="media/image//7adc7cf4344af5eb3c78a3999c5f09a3.png"><img src="images/add-image.png" width="32" class="img-abs-center" alt=""></div>
                        <input type="hidden" name="source_name[]" id="img" value="7adc7cf4344af5eb3c78a3999c5f09a3.png">
                        <input type="hidden" name="source_name[7adc7cf4344af5eb3c78a3999c5f09a3.png][extra_photo]" id="img" value="{&quot;error&quot;:&quot;0&quot;}">
                        <input type="hidden" name="source_name[7adc7cf4344af5eb3c78a3999c5f09a3.png][extra_photo_average_colour]" id="img" value="767891">
                        <input type="hidden" name="source_name[7adc7cf4344af5eb3c78a3999c5f09a3.png][extra_photo_Lat]" id="img" value="0">
                        <input type="hidden" name="source_name[7adc7cf4344af5eb3c78a3999c5f09a3.png][extra_photo_Lng]" id="img" value="0">
                    </div>
				</div>
			</div>
		</div>
        
        <button type="submit" class="button-salva-modifiche">salva modifiche</button>
    </form>  	
  </div>
 </div>
</div>

</body>
</html>