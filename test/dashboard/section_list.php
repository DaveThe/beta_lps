<?php 

namespace Dashboard;
include_once(dirname(__FILE__).'/config/include.php');
include_once('operation_foo.php');

$ParametersList['pagination'] = true;
$element 			= Section::GetElementsList($ParametersList);

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
                
				<?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('alerts_callouts.php'); ?>
				
				<?php include_once('search_element.php'); ?>
				
				<?php if(sizeof($element) > 0) { ?>
                				
					<div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Data Panel</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Nome esteso</th>
                                            <th>Nome area</th>
                                            <th>Descrizione</th>
											<th><?php echo ( (($PUBLISH) ? 'Status' : '') ); ?></th>
                                        </tr>
										<?php foreach ($element as $el) { ?>
                                        <tr>
                                            <td style="line-height: 45px;"><?php echo ($el['display_name']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['area_name']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['title']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ( ( ($PUBLISH) ? '<a href="#" onclick="'.( ($el['status'] == 0 ) ? 'approva' : 'disapprova').'P('.$el['id'].');" ><span class="label label-'.( ($el['status'] == 0 ) ? 'warning' : 'success'). '">'.( ($el['status'] == 0 ) ? 'Approve' : 'Disapproved').'</span></a>' : '' ) ); ?></td>
                                        </tr>
										<?php } ?>                                        
                                    </table>
                                </div><!-- /.box-body -->
								<?php if($element->count() > 1) { ?>
									
									<div class="box-footer clearfix">
										<ul class="pagination pagination-sm no-margin pull-right">
											<li><?php if($_pag > 1) echo '<a href="'. $_SERVER['PHP_SELF'] .'?pag='.($_pag-1).'&'.$querystring.'">&lsaquo;</a>'; ?></li>											
											<li><a href="#">Page <?php echo $_pag;?> of <?php echo $element->getTotalItemCount();?></a></li>
											<li><?php if($_pag < $element->getTotalItemCount()) echo '<a href="'. $_SERVER['PHP_SELF'] .'?pag='.($_pag+1).'&'.$querystring.'">&raquo;</a>'; ?></li>
										</ul>
									</div>
									
								<?php }  ?>
                            </div><!-- /.box -->
							
							
                        </div>
                    </div>
          
          		<?php }	?>	
                
<!-- END PAGE -->
<?php include_once('footer.php')?>