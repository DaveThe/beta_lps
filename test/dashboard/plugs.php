<?php											
    include_once(dirname(__FILE__).'/config/include.php');
    
    if( !(isset($_page) && $_page != NULL) || !(isset($_page) && $_page != NULL) )
    {
    	header('Location: error/500.php?resp_code=615');
    	exit ();        
    }
    (file_exists(PLUGIN_PATH.$_plug.'/operations.php')) ? include(PLUGIN_PATH.$_plug.'/operations.php') : NULL;
    //include_once('operation_foo.php');
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo (NOME_PRJ); ?> | <?php echo($area[PAGE_NAME]['title']); ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <?php include_once('resource.php'); ?>
        <?php include_once('operation_js.php'); ?>
        
    </head>

    <body class="sidebar-mini skin-<?php echo ( $Dashboard_user->GetSkin() ); ?>-light ">

        <div class="wrapper">
        
    		<?php include_once('header.php'); ?>
    		
    		<?php include_once('menu_left.php'); ?>
                
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
    		<?php include_once('page_bar.php'); ?>		               

                <?php include(PLUGIN_PATH.$_plug.'/'.$_page); ?>
                
<!-- END PAGE -->
<?php include_once('footer.php')?>