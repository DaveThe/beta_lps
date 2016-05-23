			
                <?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('alerts_callouts.php'); ?>
                	
					<!-- Custom Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li onclick="ChangeTabs('tab_1');" class="active"><a href="#tab_1" data-toggle="tab">User Data</a></li>
							<li <?php if(isset($id)) { ?> <?php } else { ?> class="disabled" <?php } ?> ><a href="#tab_2" <?php if(isset($id)) { ?> data-toggle="tab" <?php } ?>>Extra</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<!-- general form elements disabled -->

									<div class="box-body">
										<form role="form" method="post">
										
											<input type="hidden" name="act" value="tab_1" />
                                            <div class="MKU_IMG" id="avatar"><input type="hidden" id="img" value="<?php echo (isset($element->img) ? $element->img : ''); ?>"/></div>
                                            <?php /*
                                            <div class="col-sm-3">
                                                																
    											<div class="form-group">
                                                
    												<div class="field">
    													<img id="img_src" <?php echo(isset($element->img) ? 'src="'.JAVA_PATH.$config_upload["AVATAR"]["opzioni"]["dest_path"] . $element->img .'"':''); ?> class="thumbnail img-responsive" style="min-height: 225px; min-width: 225px;" /><br />
    													                                                                            
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" name="avatar" id="avatar"  class="form-control"  value="<?php echo(isset($element->img)?$element->img:''); ?>" >
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-info btn-flat" type="button"id="upload_btn" >Carica</button>
                                                            </span>
                                                        </div><!-- /input-group -->                                                        
    												</div>
    											</div>	
                                            
                                            </div>
                                            */ ?>
                                            
                                            <div class="col-sm-9">
                                                                                                			
    											<div class="form-group">
    												<label for="nickname">Nickname</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" placeholder="Nickname" id="nickname" name="nickname" value="<?php echo(isset($element->nickname)?$element->nickname:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>	
                											
    											<div class="form-group">
    												<label for="email">Email address</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                        <input type="text" class="form-control" placeholder="Email" id="email" name="email" value="<?php echo(isset($element->email)?$element->email:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="username">Username</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" placeholder="Username" id="username" name="username" value="<?php echo(isset($element->username)?$element->username:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="password">Password</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="<?php echo(isset($element->password)? $sec->decript($element->password) :''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="conferma_password">Confirm Password</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                        <input type="password" class="form-control" placeholder="Confirm Password" id="conferma_password" name="conferma_password" value="<?php echo(isset($element->password)? $sec->decript($element->password) :''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                											                											
    											<div class="form-group">
    												<label for="gender">Sex</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-group"></i></span>
        												<select class="form-control" id="gender" name="gender">
        													<option value="0" <?php echo ( ( isset($element->gender) && $element->gender == '0' ) ? 'selected="selected"': '' ); ?>>Uomo</option>
        													<option value="1" <?php echo ( ( isset($element->gender) && $element->gender == '1' ) ? 'selected="selected"': '' ); ?>>Donna</option>
        													<option value="2" <?php echo ( ( isset($element->gender) && $element->gender == '2' ) ? 'selected="selected"': '' ); ?>>Altro</option>
        												</select>                                                        
                                                    </div>
                                                </div>		
                                                			
    											<div class="form-group">
    												<label for="name">Name</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                                        <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="<?php echo(isset($element->name)?$element->name:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="surname">Surname</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                                        <input type="text" class="form-control" placeholder="Surname" id="surname" name="surname" value="<?php echo(isset($element->surname)?$element->surname:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="country">Country</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                                        <input type="text" class="form-control" placeholder="Country" id="country" name="country" value="<?php echo(isset($element->country)?$element->country:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="city">City</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                                        <input type="text" class="form-control" placeholder="City" id="city" name="city" value="<?php echo(isset($element->city)?$element->city:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="timing">Timing</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                                        <input type="text" class="form-control" placeholder="Timing" id="timing" name="timing" value="<?php echo(isset($element->timing)?$element->timing:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="timers">Timers</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                                        <input type="text" class="form-control" placeholder="Timers" id="timers" name="timers" value="<?php echo(isset($element->timers)?$element->timers:''); ?>" onchange="ChangeForm();">
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
