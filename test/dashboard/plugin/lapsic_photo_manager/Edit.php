			
                <?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('alerts_callouts.php'); ?>
                	
					<!-- Custom Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li onclick="ChangeTabs('tab_1');" class="active"><a href="#tab_1" data-toggle="tab">Photo Data</a></li>
							<li <?php if(isset($id)) { ?> <?php } else { ?> class="disabled" <?php } ?> ><a href="#tab_2" <?php if(isset($id)) { ?> data-toggle="tab" <?php } ?>>Extra</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<!-- general form elements disabled -->

									<div class="box-body">
										<form role="form" method="post">
										
											<input type="hidden" name="act" value="tab_1" />
                                            <div class="MKU_IMG" id="image"><input type="hidden" id="source_name" value="<?php echo (isset($element->source_name) ? $element->source_name : ''); ?>"/></div>
                                            
                                            <input type="hidden" name="extra_photo" id="extra_photo" value="" />
                                            <input type="hidden" name="extra_photo_average_colour" id="extra_photo_average_colour" value="" />
                                            <input type="hidden" name="extra_photo_Lat" id="extra_photo_Lat" value="" />
                                            <input type="hidden" name="extra_photo_Lng" id="extra_photo_Lng" value="" />
                                                   
                                            <div class="col-sm-9">
                                                                                                			
    											<div class="form-group">
    												<label for="name">Nome</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" placeholder="name" id="name" name="name" value="<?php echo(isset($element->name)?$element->name:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>	
                											
    											<div class="form-group">
    												<label for="description">Descrizione</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                        <input type="text" class="form-control" placeholder="description" id="description" name="description" value="<?php echo(isset($element->description)?$element->description:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                
											</div>
                                            
											<div class="box-footer">
												<button type="submit" class="btn btn-primary">Submit</button>
											</div>			
										</form>
									</div><!-- /.box-body -->
								
							</div><!-- /.tab-pane -->
							
							<div class="tab-pane" id="tab_2">							
								<!-- general form elements disabled -->
									<div class="box-body">
										<form role="form" method="post">
											<input type="hidden" name="act" value="tab_2" />
											<!-- <div class="box"> 
												<div class="box-body table-responsive no-padding">-->
													
														<?php  foreach($elements_extra_data as $group => $el_group){ ?>
																		
                                        					<div class="row">
                                                                <div class="col-xs-12">
                                                                    <div class="box">
                                                                        <div class="box-header">
                                                                            <h3 class="box-title"><?php echo ($group); ?></h3>
                                                                        </div><!-- /.box-header -->
                                                                        <div class="box-body table-responsive no-padding">
                                                                            <table class="table table-hover">
                                                                                <tr>
                                                                                    <th>Description</th>
                                                                                    <th>Values</th>
                                                                                    <th>Date</th>
                                        											<?php /* <th><?php echo ( (($WRITE) ? 'Edit' : '') ); ?></th> */ ?>
                                        											<th><?php echo ( (($DELETE) ? 'Delete' : '') ); ?></th>
                                                                                    <th><?php echo ( (($PUBLISH) ? 'Status' : '') ); ?></th>
                                                                                </tr>
                                        										<?php foreach ($el_group as $el) { ?>
                                                                                <tr>
                                                                                    <td style="line-height: 45px;"><?php echo ($el['description']); ?></td>
                                                                                    <td style="line-height: 45px;"><?php echo ($el['value']); ?></td>
                                                                                    <td style="line-height: 45px;"><?php echo (Dashboard\DateFormat::echoDate($el['data_creation'], IT) ); ?></td>
                                        											<?php /* <td style="line-height: 45px;"><?php echo ( ( ($WRITE) ? '<a href="'.str_replace('_list','_edit',$sub_area['page']).'.php?id='.$el['id'].'" ><span class=" iconia glyphicon glyphicon-pencil"></span></a>' : '') ); ?></td> */ ?>
                                        											<td style="line-height: 45px;"><?php echo ( ( ($DELETE) ? '<a href="#" onclick="deleteData('.$el['id'].');" ><span class=" iconia glyphicon glyphicon-trash"></span></a>' : '') ); ?></td>
                                                                                    <td style="line-height: 45px;"><?php echo ( ( ($PUBLISH) ? '<a href="#" onclick="'.( ($el['status'] == 0 ) ? 'approva' : 'disapprova').'Data('.$el['id'].');" ><span class="label label-'.( ($el['status'] == 0 ) ? 'warning' : 'success'). '">'.( ($el['status'] == 0 ) ? 'Approve' : 'Disapproved').'</span></a>' : '' ) ); ?></td>
                                                                                </tr>
                                        										<?php } ?>                                        
                                                                            </table>
                                                                        </div><!-- /.box-body -->
                                                                    </div><!-- /.box -->
                                                                </div>
                                                            </div>
														<?php } ?>
                                                        
											<!--</div><!-- /.box-body -->
											<!--</div><!-- /.box -->
											
											<div class="box-footer">
												<button type="submit" class="btn btn-primary">Submit</button>
											</div>			
										</form>
									</div><!-- /.box-body -->
									
							</div><!-- /.tab-pane -->
						</div><!-- /.tab-content -->
					</div><!-- nav-tabs-custom -->
