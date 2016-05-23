<?php 

include_once(dirname(__FILE__).'/config/include.php');
include_once('operation_foo.php');
$ParametersList['pagination'] = true;
$element 			= $plugins::GetElementsList($ParametersList);

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
				
					<div Class="row">
                        <div Class="col-xs-12">
                            <div Class="box">
                                <div Class="box-header">
                                    <h3 Class="box-title">Data Panel</h3>
                                    <!--<div Class="box-tools">
                                        <div Class="input-group">
                                            <input type="text" name="table_search" Class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                            <div Class="input-group-btn">
                                                <button Class="btn btn-sm btn-default"><i Class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>-->
                                </div><!-- /.box-header -->
                                <div Class="box-body table-responsive no-padding">
                                    <table Class="table table-hover">
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Author</th>
                                            <th>Site</th>
                                            <th>Version</th>
                                            <th>Description</th>
											<th><?php echo ( (($WRITE) ? 'Show' : '') ); ?></th>	
                                            <th><?php echo ( (($WRITE) ? 'Install' : '') ); ?></th>
                                            <th><?php echo ( (($WRITE) ? 'Status' : '') ); ?></th>
                                        </tr>
										<?php $i = 0; foreach ($element as $el) { ?>
                                        <tr>
                                            <td><img src="<?php echo (PLUGIN_MEDIA_PATH.$el['name'].'/info/'.$el['img']); ?>"Class="img-circle" alt="User Image" width="45" height="45" /></td>
                                            <td style="line-height: 45px;"><?php echo ($el['display_name']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['author']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['site']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['version']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['description']); ?></td>
											<td style="line-height: 45px;"><?php echo ( ( ($WRITE) ? '<a href="'.str_replace('_list','_edit',$sub_area['page']).'.php?id='.$el['id'].'" ><span class=" iconia glyphicon glyphicon-new-window"></span></a>' : '') ); ?></td>
                                            <td style="line-height: 45px;"><?php echo ( ( ($PUBLISH && $el['type_plugin'] == 'section') ? '<a href="#" onclick="installSection('.$el['id'].');" ><span class="label label-'.( ($el['status'] == 0 ) ? 'warning' : 'success disabled'). '">'.( ($el['status'] == 0 ) ? 'Install' : 'Uninstall').'</span></a>' : '' ) ); ?></td>
                                            <td style="line-height: 45px;"><?php echo ( ( ($PUBLISH) ? '<a href="#" onclick="'.( ($el['status'] == 0 ) ? 'approva' : 'disapprova').'P('.$el['id'].');" ><span class="label label-'.( ($el['status'] == 0 ) ? 'warning' : 'success'). '">'.( ($el['status'] == 0 ) ? 'Approve' : 'Disapproved').'</span></a>' : '' ) ); ?></td>
                                        </tr>
										<?php $i++; } ?>                                        
                                    </table>
                                </div><!-- /.box-body -->
								<?php if($element->count() > 1) { ?>
									
									<div Class="box-footer clearfix">
										<ul Class="pagination pagination-sm no-margin pull-right">
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