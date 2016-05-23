				<?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('alerts_callouts.php'); ?>
                	<!-- Custom Tabs -->
                	<div class="nav-tabs-custom">
                		<div class="tab-content">
                			<div class="tab-pane active" id="tab_1">
                				<!-- general form elements disabled -->
                                <div class="box-body">
                                    <form role="form" method="post">
                                        <input type="hidden" name="act" value="save" />      
                                        				
                        				<div class="form-group">
                        					<label for="area_name">Titolo*</label>
                                                
                                            <div class="input-group">
                        						
                                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                <input type="text" class="form-control" placeholder="Titolo" id="title" name="title" value="<?php echo(isset($element->title)?$element->title:''); ?>" onchange="ChangeForm();">
                                            </div>
                                        </div>
                                        				
                        				<div class="form-group">
                        					<label for="area_name">Sottotitolo*</label>
                                                
                                            <div class="input-group">
                        						
                                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                <input type="text" class="form-control" placeholder="Sottotitolo" id="subtitle" name="subtitle" value="<?php echo(isset($element->subtitle)?$element->subtitle:''); ?>" onchange="ChangeForm();">
                                            </div>
                                        </div>
                                                             
                                        <div class='box box-info'>
                                            <div class='box-header'>
                                                <h3 class='box-title'>Testo*</h3>
                                                <!-- tools box -->
                                                <div class="pull-right box-tools">
                                                    <p class="btn btn-info btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></p>
                                                    <!--<p class="btn btn-info btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></p>-->
                                                </div><!-- /. tools -->
                                            </div><!-- /.box-header -->
                                            <div class='box-body pad'>
                                                    <textarea id="editor1" name="text" rows="10" cols="80">
                                                        <?php echo (isset($element->text) ? $element->text : ''); ?>
                                                    </textarea>
                                            </div>
                                        </div><!-- /.box -->
                                                                                
										<!-- textarea -->
										<div class="form-group">
											<label>Testo breve*</label>
											<textarea class="form-control" rows="3" placeholder="Enter ..." name="abstract" maxlength="200" onchange="ChangeForm();" id="ckedit_text"><?php echo (isset($element->abstract) ? $element->abstract : ''); ?></textarea>
										</div>
                                    <?php /*    
                                        <!-- Date dd/mm/yyyy -->
                                        <div class="form-group">
                                            <label>Data Articolo*:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" id="date_input" name="date_input" class="form-control" value="<?php echo (isset($element->date_input) ? $element->date_input : ''); ?>" onchange="ChangeForm();" />
                                            </div><!-- /.input group -->
                                        </div><!-- /.form group -->
                                    
                                    */ ?>
                                        <!-- Date dd/mm/yyyy -->
                                        <div class="form-group">
                                            <label>Data pubblicazione articolo*:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" id="date_begin" name="date_begin" class="form-control" value="<?php echo (isset($element->date_begin) ? $element->date_begin : ''); ?>" onchange="ChangeForm();" />
                                            </div><!-- /.input group -->
                                        </div><!-- /.form group -->
                                        
                                        
                                        <!-- Date dd/mm/yyyy -->
                                        <div class="form-group">
                                            <label>Data fine articolo*:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" id="date_end" name="date_end" class="form-control" value="<?php echo (isset($element->date_end) ? $element->date_end : ''); ?>" onchange="ChangeForm();"/>
                                            </div><!-- /.input group -->
                                        </div><!-- /.form group -->     
                                             
                                        <div class="MKU_DND" id="news_dett"><input type="hidden" id="img_big" value="<?php echo (isset($element->img_big) ? $element->img_big : ''); ?>"/></div>
                                        <?php /* <div class="MKU_IMG_2" id="about"></div> */ ?>
                                                                                                    
                    					<div class="box-footer">
                    						<button type="submit" class="btn btn-primary">Submit</button>
                    					</div>			
                    				</form>
                    			</div><!-- /.box-body -->
                            
                    		</div><!-- /.tab-pane -->
            
						</div><!-- /.tab-content -->
					</div><!-- nav-tabs-custom -->
