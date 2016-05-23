			
                <?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('alerts_callouts.php'); ?>
                	
					<!-- Custom Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li onclick="ChangeTabs('tab_1');" class="active"><a href="#tab_1" data-toggle="tab">Group Data</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<!-- general form elements disabled -->

									<div class="box-body">
										<form role="form" method="post">
										
											<input type="hidden" name="act" value="tab_2" />
                                            
                                            <div class="col-sm-12">
                                                                                                			
    											<div class="form-group">
    												<label for="value">Nome corto del dato extra</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <?php /*<input type="text" class="form-control" placeholder="Generic" id="value" name="value" value="<?php echo(isset($elements_group->value)?$elements_group->value:''); ?>" onchange="ChangeForm();"> */?>
                                                        <input type="text" class="form-control" placeholder="" id="value" name="value" value="<?php echo(isset($elements_extra->value)?$elements_extra->value:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                    
                                                </div>	
											</div>                                                
                                                
                                            <div class="col-sm-12">
                                                                                                			
    											<div class="form-group">
    												<label for="description">Descrizione</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" placeholder="" id="description" name="description" value="<?php echo(isset($elements_extra->description)?$elements_extra->description:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                    
                                                </div>	
											</div>
                                                
											<div class="box-footer">
												<button type="submit" class="btn btn-primary">Submit</button>
											</div>			
										</form>
									</div><!-- /.box-body -->
								
							</div><!-- /.tab-pane -->
                            
						</div><!-- /.tab-content -->
					</div><!-- nav-tabs-custom -->
