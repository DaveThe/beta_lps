<?php 
namespace Dashboard;
include_once(dirname(__FILE__).'/core/class/LapsicPhoto.php');
//$querystring = 'plug=news-manager&p_page=Edit.php';

$ParametersList['pagination'] = true;

$elements 			= LapsicPhoto::GetElementsList($ParametersList);

?>
            <?php if(sizeof($errors) > 0 || $respok !== false || sizeof($elements) == 0) include_once('alerts_callouts.php'); ?>
				<?php include_once('search_element.php'); ?>
				
				<?php if(sizeof($elements) > 0) { ?>
                				
					<div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Data Panel</h3>
                                    <!--<div class="box-tools">
                                        <div class="input-group">
                                            <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>-->
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tr>                             
                                            <th>name</th>
                                            <th>description</th>
                                            <th>GPS</th>
                                            <th>User</th>
                                            <th>time_left</th>
                                            <th>average_colour</th>
                                            <th>source_path</th>
                                            <th>source_name</th>
                                            <th>Ip Address</th>
                                            <th>Data iscrizione</th>
											<th><?php echo ( (($WRITE) ? 'Edit' : '') ); ?></th>
											<th><?php echo ( (($DELETE) ? 'Delete' : '') ); ?></th>
                                            <th><?php echo ( (($PUBLISH) ? 'Status' : '') ); ?></th>
                                        </tr>
										<?php foreach ($elements as $el) {?>
                                        <tr>
                                            <td style="line-height: 45px;"><?php echo ($el['name']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['description']); ?></td>
                                            <td style="line-height: 45px;"><a target="_blank" href='https://maps.google.com/maps?q=<?php echo ($el['lat']. "," .$el['lng']); ?>'>Mappa</a></td>
                                            <td style="line-height: 45px;"><?php echo ($el['user']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['time_left']); ?></td>
                                            <td style="line-height: 45px;"><div style="width: 24px; height:  24px; background-color: #<?php echo ($el['average_colour']); ?>"></div></td>
                                            <td style="line-height: 45px;"><?php echo ($el['source_path']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['source_name']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['ip_address']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['data_creation']); ?></td>
											<td style="line-height: 45px;"><?php echo ( ( ($WRITE) ? '<a href="plugs.php?plug='.$_plug.'&p_page=Edit.php&id='.$el['id'].'" ><span class=" iconia glyphicon glyphicon-pencil"></span></a>' : '') ); ?></td>
											<td style="line-height: 45px;"><?php echo ( ( ($DELETE) ? '<a href="#" onclick="deleteP('.$el['id'].');" ><span class=" iconia glyphicon glyphicon-trash"></span></a>' : '') ); ?></td>
                                            <td style="line-height: 45px;"><?php echo ( ( ($PUBLISH) ? '<a href="#" onclick="'.( ($el['status'] == 0 ) ? 'approva' : 'disapprova').'P('.$el['id'].');" ><span class="label label-'.( ($el['status'] == 0 ) ? 'warning' : 'success'). '">'.( ($el['status'] == 0 ) ? 'Approve' : 'Disapproved').'</span></a>' : '' ) ); ?></td>
                                        </tr>
										<?php } ?>                                        
                                    </table>
                                </div><!-- /.box-body -->
								<?php if($elements->count() > 1) { ?>
									
									<div class="box-footer clearfix">
										<ul class="pagination pagination-sm no-margin pull-right">
											<li><?php if($_pag > 1) echo '<a href="'. $_SERVER['PHP_SELF'] .'?pag='.($_pag-1).'&'.$querystring.'">&lsaquo;</a>'; ?></li>											
											<li><a href="#">Page <?php echo $_pag;?> of <?php echo $elements->getTotalItemCount();?></a></li>
											<li><?php if($_pag < $elements->getTotalItemCount()) echo '<a href="'. $_SERVER['PHP_SELF'] .'?pag='.($_pag+1).'&'.$querystring.'">&raquo;</a>'; ?></li>
										</ul>
									</div>
									
								<?php }  ?>
                            </div><!-- /.box -->
							
							
                        </div>
                    </div>
          
          		<?php }	?>	