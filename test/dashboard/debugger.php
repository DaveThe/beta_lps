<?php 
include_once(dirname(dirname(__FILE__)).'/config/config.php');
include_once('class_debug.php');
include_once('super.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo (NOME_PRJ); ?> | DEBUGGER</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		    
		<?php include_once(THEME.'/include/lib_js.php'); ?>
	<?php 
    if(!isset($_SESSION['var_dump']))
    { ?>
     <script type="text/javascript">
	 window.close();
	 </script>   
    <?php }	?>
	</head>


    <body class="sidebar-mini skin-<?php echo ( $Dashboard_user->GetSkin() ); ?>-light ">
		
        <div Class="wrapper row-offcanvas row-offcanvas-left">
				<?php include_once('page_bar.php'); ?>
				
					<div Class="row">
                        <div Class="col-xs-12">
							
                            <div Class="box box-solid">
                                <div Class="box-header">
                                    <h3 Class="box-title">Collapsible Accordion</h3>
                                </div><!-- /.box-header -->
                                <div Class="box-body">
                                    <div Class="box-group" id="accordion">
										<?php
										$single = SingDebug::getInstance();
										 if(sizeof($single->getVar())>0) { $i = 0; ?>
											<?php foreach ($single->getVar() as $el) { ?>
												<!-- we are adding the .panel Class so bootstrap.js collapse plugin detects it -->
												<div Class="panel box box-primary">
													<div Class="box-header">
														<h4 Class="box-title">
															<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne_<?php echo ( $i ); ?>">
																<?php echo ( $el['Class'] ); ?> - <?php echo ( $el['FOO'] ); ?> - <?php echo ( $el['file'] ); ?>
															</a>
														</h4>
													</div>
													<div id="collapseOne_<?php echo ( $i ); ?>" Class="panel-collapse collapse in">
														<div Class="box-body">
															<?php echo ( $el['values'] ); ?>
														</div>
													</div>
												</div>
											<?php $i++; } ?>
										<?php } ?>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->							
                        </div>
                    </div>
				
				</section><!-- /.content -->
			</aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

    </body>
</html>
<?php unset($_SESSION['var_dump']); ?>