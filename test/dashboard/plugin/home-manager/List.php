<?php 
namespace Dashboard;
include_once(dirname(__FILE__).'/core/class/HomeBlock.php');
//include_once(dirname(dirname(dirname(__FILE__))).'/config/include.php');
//echo dirname(__FILE).'/core/class/class_news.php';
//include_once(dirname(__FILE).'/core/class/class_news.php');
//include_once('operations.php');
//$querystring = 'plug=news-manager&p_page=Edit.php';

$ParametersList['pagination'] = true;

$element 			= HomeBlock::GetElementsList($ParametersList);

?>
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
                                            <th>Titolo</th>
                                            <th>Sottotitolo</th>
                                            <th>Data pubblicazione</th>
											<th><?php echo ( (($WRITE) ? 'Edit' : '') ); ?></th>
											<th><?php echo ( (($DELETE) ? 'Delete' : '') ); ?></th>
                                            <th><?php echo ( (($PUBLISH) ? 'Status' : '') ); ?></th>
                                        </tr>
										<?php foreach ($element as $el) {?>
                                        <tr>
                                            <td style="line-height: 45px;"><?php echo ($el['title']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['subtitle']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['date_begin']); ?></td>
											<td style="line-height: 45px;"><?php echo ( ( ($WRITE) ? '<a href="plugs.php?plug='.$_plug.'&p_page=Edit.php&id='.$el['id'].'" ><span class=" iconia glyphicon glyphicon-pencil"></span></a>' : '') ); ?></td>
											<td style="line-height: 45px;"><?php echo ( ( ($DELETE) ? '<a href="#" onclick="deleteP('.$el['id'].');" ><span class=" iconia glyphicon glyphicon-trash"></span></a>' : '') ); ?></td>
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