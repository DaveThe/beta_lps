<?php
include_once(dirname(__FILE__).'/config/include.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!--<meta charset="UTF-8">-->
        <title><?php echo (NOME_PRJ); ?> | <?php echo($area[PAGE_NAME]['title']); ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <?php include_once('resource.php'); ?>
    </head>

    <body class="sidebar-mini skin-<?php echo ( $Dashboard_user->GetSkin() ); ?>-light ">

        <div class="wrapper">
        
    		<?php include_once('header.php'); ?>
    		
    		<?php include_once('menu_left.php'); ?>
                
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
    		<?php include_once('page_bar.php'); ?>
    
    				<?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('alerts_callouts.php'); ?>				               
                    
    		
<!-- END PAGE -->
<?php include_once('footer.php')?>