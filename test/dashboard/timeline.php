<?php
include_once(dirname(__FILE__).'/config/include.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo (NOME_PRJ); ?> | <?php echo($area['title']); ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <?php include_once(THEME.'/include/lib_js.php'); ?>	
        
    </head>

    <body class="sidebar-mini skin-<?php echo ( $Dashboard_user->GetSkin() ); ?>-light ">

		<?php include_once('header.php'); ?>
		
        <div Class="wrapper row-offcanvas row-offcanvas-left">
		<?php include_once('menu_left.php'); ?>
		<?php include_once('page_bar.php'); ?>

				<?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('alerts_callouts.php'); ?>				               
                
                <ul Class="timeline">
                
                    <!-- timeline time label -->
                    <li Class="time-label">
                        <span Class="bg-red">
                            10 Feb. 2014
                        </span>
                    </li>
                    <!-- /.timeline-label -->
                
                    <!-- timeline item -->
                                <!-- timeline item -->
                                <li>
                                    <i Class="fa fa-comments bg-yellow"></i>
                                    <div Class="timeline-item">
                                        <span Class="time"><i Class="fa fa-clock-o"></i> 27 mins ago</span>
                                        <h3 Class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                                        <div Class="timeline-body">
                                            Take me to your leader!
                                            Switzerland is small and neutral!
                                            We are more like Germany, ambitious and misunderstood!
                                        </div>
                                        <div Class='timeline-footer'>
                                            <a Class="btn btn-warning btn-flat btn-xs">View comment</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline time label -->
                                <li Class="time-label">
                                    <span Class="bg-green">
                                        3 Jan. 2014
                                    </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i Class="fa fa-camera bg-purple"></i>
                                    <div Class="timeline-item">
                                        <span Class="time"><i Class="fa fa-clock-o"></i> 2 days ago</span>
                                        <h3 Class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                                        <div Class="timeline-body">
                                            <img src="http://placehold.it/150x100" alt="..." Class='margin' />
                                            <img src="http://placehold.it/150x100" alt="..." Class='margin'/>
                                            <img src="http://placehold.it/150x100" alt="..." Class='margin'/>
                                            <img src="http://placehold.it/150x100" alt="..." Class='margin'/>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <li>
                                    <i Class="fa fa-video-camera bg-maroon"></i>
                                    <div Class="timeline-item">
                                        <span Class="time"><i Class="fa fa-clock-o"></i> 5 days ago</span>
                                        <h3 Class="timeline-header"><a href="#">Mr. Doe</a> shared a video</h3>
                                        <div Class="timeline-body">
                                            <iframe width="300" height="169" src="//www.youtube.com/embed/fLe_qO4AE-M" frameborder="0" allowfullscreen></iframe>
                                        </div>
                                        <div Class="timeline-footer">
                                            <a href="#" Class="btn btn-xs bg-maroon">See comments</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <li>
                                    <i Class="fa fa-clock-o"></i>
                                </li>
                
                </ul>
                
                
				</section><!-- /.content -->
			</aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
	    <?php include_once('enable_plugin_js.php'); ?>
    </body>
</html>
<?php include_once('footer.php')?>