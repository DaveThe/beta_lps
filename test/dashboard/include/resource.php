<?php /** INCLUDE JS E CSS **/?>
<link rel="shortcut icon" href="<?php echo(MEDIA_PATH.'favicon/favicon.ico'); ?>" type="image/x-icon">
<link rel="icon" href="<?php echo(MEDIA_PATH.'favicon/favicon.ico'); ?>" type="image/x-icon">

<?php /** INCLUDE THEME CSS **/ ?>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        
<?php /* FONTS */ ?>        
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        
<?php /* JQUERY UI CSS */ ?>

<?php /* BOOTSTRAP CSS */ ?> 

    <!-- Theme style -->
    <link href="css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    
    
<?php /* FANCYBOX CSS */ ?>
        <link href="js/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />

<?php /* JAVASCRIPT */ ?>

<?php /* JQUERY */ ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<?php /* JQUERY UI */ ?>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<?php /* BOOTSTRAP */ ?> 
        <script src="bootstrap/js/bootstrap.min.js" defer></script>
<?php /* FANCYBOX */ ?> 
        <script src="js/fancybox/jquery.fancybox.js" type="text/javascript" defer></script>

<?php /** INCLUDE THEME **/ ?>
        <!-- AdminLTE App -->
        <script src="js/script/app.min.js" type="text/javascript" defer></script>

<?php /*************/ ?>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
<script src="js/script/common.js" type="text/javascript" defer></script>
    <!-- FastClick -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min.js'></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.3/jquery.slimscroll.min.js" type="text/javascript" defer></script>
<?php if(isset($settings->stato_GA) && $settings->stato_GA) include_once(DASHBOARD_PATH.'js/GAnalytics/googleanalytics.php'); ?>
<script type="text/javascript"> function ChangeForm(){}</script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.1/skins/square/blue.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.1/icheck.min.js" type="text/javascript" defer></script>