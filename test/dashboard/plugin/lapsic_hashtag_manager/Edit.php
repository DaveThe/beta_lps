			
                <?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('alerts_callouts.php'); ?>
                	
					<!-- Custom Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li onclick="ChangeTabs('tab_1');" class="active"><a href="#tab_1" data-toggle="tab">Tag Data</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<!-- general form elements disabled -->

									<div class="box-body">
										<form role="form" method="post">
										
											<input type="hidden" name="act" value="tab_1" />
                                            
                                            <div class="col-sm-12">
                                                                                                			
    											<div class="form-group">
    												<label for="hashtag">Hashtag</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" placeholder="#Hashtag" id="hashtag" name="hashtag" value="<?php echo(isset($element->tag_name)?$element->tag_name:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                    
                                                </div>	
											</div>
                                            
                                            <?php if(isset($id) && $id != '') { ?>
                                                
                                                
                                                <div class="col-sm-12">
                                                                                                    			
        											<div class="form-group">
        												<label for="source">Sorgente</label>
                                                            
                                                        <div class="input-group">
            												
                                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                            <input type="text" class="form-control" placeholder="" id="source" name="source" value="<?php echo(isset($element->tag_original)?$element->tag_original:''); ?>" onchange="ChangeForm();">
                                                        </div>
                                                        
                                                    </div>	
    											</div>
                                                                                     
                                                
                                                <div class="col-sm-12">
                                                                                                    			
        											<div class="form-group">
        												<label for="ipaddress">Ip address</label>
                                                            
                                                        <div class="input-group">
            												
                                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                            <input type="text" class="form-control" placeholder="" id="ipaddress" name="ipaddress" value="<?php echo(isset($element->ip_address)?$element->ip_address:''); ?>" onchange="ChangeForm();">
                                                        </div>
                                                        
                                                    </div>	
    											</div>                                         
                                                
                                                
                                                <div class="col-sm-12">
                                                                                                    			
        											<div class="form-group">
        												<label for="user">User</label>
                                                            
                                                        <div class="input-group">
            												
                                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                            <input type="text" class="form-control" placeholder="" id="user" name="user" value="<?php echo(isset($element->user)?$element->user:''); ?>" onchange="ChangeForm();">
                                                        </div>
                                                        
                                                    </div>	
    											</div>
                                                
                                                <div class="col-sm-12">
                                                                                                    			
        											<div class="form-group">
        												<label for="group">Group</label>
                                                            
                                                        <div class="input-group">
            												
                                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                            <input type="text" class="form-control" placeholder="" id="group" name="group" value="<?php echo(isset($element->description)?$element->description:''); ?>" onchange="ChangeForm();">
                                                        </div>
                                                        
                                                    </div>	
    											</div>
                                                
                                                <div class="col-sm-12">
        											<div class="form-group">
        												<label for="group">Group</label>
                                                            
                                                        <div class="input-group">
            												
                                                            <span class="input-group-addon"><i class="fa fa-group"></i></span>
            												<select class="form-control" id="group" name="group">
                                                                <?php foreach($groups as $g){ ?>
            													<option value="<?php echo ($g['id']) ?>" <?php echo ( ( isset($element->id_group) && $element->id_group == $g['id'] ) ? 'selected="selected"': '' ); ?>><?php echo ($g['value']) ?></option>
            												    <?php } ?>
                                                            </select>                                                        
                                                        </div>
                                                    </div>
    											</div>
                                                
                                            <?php } ?>
											<div class="box-footer">
												<button type="submit" class="btn btn-primary">Submit</button>
											</div>			
										</form>
									</div><!-- /.box-body -->
								
							</div><!-- /.tab-pane -->
                            
						</div><!-- /.tab-content -->
					</div><!-- nav-tabs-custom -->
