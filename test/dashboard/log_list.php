<?php 
namespace Dashboard;

include_once(dirname(__FILE__).'/config/include.php');


$ParametersList['pagination'] = true;
$element 			= Log::GetElementsList($ParametersList); //$db, 20, $_pag, $_st, $_text, $idproprio);

include_once('operation_foo.php');
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
                                    <!--<div class="box-tools">
                                        <div class="input-group">
                                            <input type="text" name="table_search" class="form-control input-sm pull-right'); ?>" style="width: 150px;" placeholder="Search"/>
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>-->
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tr>
                                            <th></th>
                                            <th>Message</th>
                                            <th>Error Code</th>
                                            <th>File</th>
                                            <th>Created By</th>
                                            <th>Data</th>
                                            <th>Status</th>
											<th><?php echo ( (($WRITE) ? 'Show' : '') ); ?></th>											
                                        </tr>
										<?php foreach ($element as $el) {
										      $user_data = '0';//($el['created_by'] == '0') ? 'System' : BoUser::GetOneUser($db, $el['created_by'])  
                                        ?>
                                        <tr>
                                            <td><span class="<?php echo ( ($el['error_type'] == '0') ? 'fa fa-warning text-warning' : 'fa fa-exclamation text-danger' ); ?>"></span></td>
                                            <td style="line-height: 45px;" id="pop" data-content="<?php echo ($el['message']); ?>"><?php echo ((strlen($el['message']) > 53) ? substr($el['message'],0,50).'...' : $el['message']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['class']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['error_file']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ( (isset($user_data) && is_array($user_data) ) ? '<a href="bo-user-edit.php?id='.$user_data['id'].'">'.$user_data['username'].'</a>' : $user_data ); ?></td>
                                            <td style="line-height: 45px;"><?php echo (DateFormat::echoDate($el['data_creation'], IT)); ?></td>
                                            <td style="line-height: 45px;">
                                            <?php if($WRITE){ ?>
                                                <select class="form-control" id="error_type" name="error_type" onchange="changeStatus('<?php echo($el['id']) ?>', this.value)">
                									<option value="0" <?php echo ( ( isset($el['status']) && $el['status'] == "0" ) ? 'selected="selected"': "" ); ?> >Irrisolto</option>
                									<option value="1" <?php echo ( ( isset($el['status']) && $el['status'] == "1" ) ? 'selected="selected"': "" ); ?>>Risolto</option>
                									<option value="2" <?php echo ( ( isset($el['status']) && $el['status'] == "2" ) ? 'selected="selected"': "" ); ?>>In attesa</option>
                								</select>
                                            <?php } ?>
                                            </td>
											<td style="line-height: 45px;"><?php echo ( ( ($WRITE) ? '<a href="'.str_replace('_list','_edit',$sub_area['page']).'.php?id='.$el['id'].'" ><span class=" iconia glyphicon glyphicon-new-window"></span></a>' : '') ); ?></td>
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
				
    <script type="text/javascript">
        $(function(){
           $('#pop').popover();
        });
    </script>
                
<!-- END PAGE -->
<?php include_once('footer.php')?>