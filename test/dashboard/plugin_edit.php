<?php 
namespace Dashboard;

include_once(dirname(__FILE__).'/config/include.php');
	
if(isset($id)) 
{
	if(!$plugins->GetElement($id))
    {
		header('Location: plugin.php?resp_code=615');
		exit ();
	}	
}

include_once('operation_foo.php');
//$elenco_aree = Sezioni::GetArea($db,'', $_SESSION['dashboard_iduser']);
/*
$ParametersList['user'] = $_SESSION['dashboard_iduser'];
$ParametersList['menu'] = false;
$ParametersList['pagination'] = false;
$elenco_aree = Sezioni::GetElementsList($ParametersList);*/
        
if(isset($_POST["act"]) && $_POST["act"]=='tab_2') {
	
	$res 		= false;
	$active_tab	= $_POST["act"];
	
	if(isset($_POST['plugin_area']) && is_array($_POST['plugin_area'])){

		$plugin_area				= array();
		$plugin_area				= $_POST['plugin_area'];
		//var_dump($_POST['plugin_area']);
        //exit();
        /*
		foreach( $_POST['plugin_area'] as $key => $value ){
			
			if( isset($value['id_area']) && is_numeric($value['id_area']) ) {} else { $errors[] = "Dati inviati non corretti"; }
			
			if( isset($value['enable']) ){
				
					if( $value['enable']==1 ){
					}else{
						$errors[] 						= "Dati inviati non corretti";
					}
			
			}else{
				$plugin_area[$key]['enable']				= 0;
			}
		}
        */
        
        /**************************STAMPA CONTROLLO*******************************/
        /*
		foreach($_POST['plugin_area'] as $key=>$value){
			
            foreach($_POST['plugin_area'][$key] as $key2=>$value2){
                echo ' -- id_area '.$key.' -- id_sub '.$key2.' => ';
                echo $value2['enable'].' - <br>';    
            }
         }*/
         
         /**************************STAMPA CONTROLLO*******************************/ 
         
         
         /**************************CONTROLLO*******************************/
		foreach($plugin_area as $key=>$value){
            foreach($plugin_area[$key] as $key2=>$value2){
                if( isset($value2['enable']) && ($value2['enable']==1 || $value2['enable']==0) ){}else{
					$errors[] 						= "Dati inviati non corretti";
				}
            }
         }   
         /**************************CONTROLLO*******************************/
        
		$plugins->plugin_area							= $plugin_area;
		
	}else{
		$errors[] = "Dati inviati non corretti";		
	}
	
    $plugins->created_by                                = ID_USER_LOG;
    
	if(sizeof($errors)==0) {
		        
		if($id>0){ //update
			$res 		= $plugins->InsertAreaPlugin();			
						
			if($res){
				$resp_code	= 510;
    				
                $action     = new LogAction($db, UPDATE, __FUNCTION__, __CLASS__, basename(__FILE__), $id, ID_USER_LOG);                            
                $ret		= $action->Insert();        	                
        		if($ret) {
        			header('Location: plugin_edit.php?id='.$plugins->id.'&resp_code='.$resp_code.'&tab='.$_POST["act"]);
        			exit ();
        		}else {		
        			$resp_code 				= 635;
        		}
			} else {
				$resp_code	= 515;
			}
		}
		
	}
}

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
				
				<?php if(sizeof($errors) > 0 || $respok !== false) include_once('alerts_callouts.php'); ?>
				
					<!-- Custom Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li onclick="ChangeTabs('tab_1');" class="active"><a href="#tab_1" data-toggle="tab">Plugin Data</a></li>
							<li <?php if(isset($id)) { ?> onclick="ChangeTabs('tab_2');" <?php } else { ?> class="disabled" <?php } ?> ><a href="#tab_2" <?php if(isset($id)) { ?> data-toggle="tab" <?php } ?>>Area Enable</a></li>
                            <?php if(file_exists(PLUGIN_PATH.$plugins->name.'/settings.php')){ ?>
							<li <?php if(isset($id)) { ?> onclick="ChangeTabs('tab_3');" <?php } else { ?> class="disabled" <?php } ?> ><a href="#tab_3" <?php if(isset($id)) { ?> data-toggle="tab" <?php } ?>>Settings</a></li>
                            <?php } ?>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<!-- general form elements disabled -->

									<div class="box-body">
										<form role="form" method="post">
										                                          
                                            <div class="col-sm-2">
                                                																
    											<div class="form-group">
                                                
    												<div class="field">
    													<img id="img_src" <?php echo(isset($plugins->img) ? 'src="'.PLUGIN_MEDIA_PATH.$plugins->name.'/info/'. $plugins->img .'"':''); ?> class="thumbnail img-responsive" style="min-height: 36px; min-width: 36px;" /><br /> 
    												</div>
    											</div>	
                                            
                                            </div>
                                            
                                            
                                            <div class="col-sm-10">
                                                                                                			
    											<div class="form-group">
    												<label for="nickname">Token</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" placeholder="Token" id="token" name="token" value="<?php echo(isset($plugins->token)?$plugins->token:''); ?>" disabled="disabled" onchange="ChangeForm();">
                                                    </div>
                                                </div>	
                											               											
    											<div class="form-group">
    												<label for="display_name">Display Name</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                        <input type="text" class="form-control" placeholder="display_name" id="display_name" name="display_name" value="<?php echo(isset($plugins->display_name)?$plugins->display_name:''); ?>" disabled="disabled" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="author">Author</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                                        <input type="text" class="form-control" placeholder="author" id="author" name="author" value="<?php echo(isset($plugins->author)?$plugins->author:''); ?>" disabled="disabled" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="version">Version</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" placeholder="version" id="version" name="version" value="<?php echo(isset($plugins->version)?$plugins->version:''); ?>" disabled="disabled" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="description">Description</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" placeholder="description" id="description" name="description" value="<?php echo(isset($plugins->description)?$plugins->description:''); ?>" disabled="disabled" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="site">Site</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" placeholder="site" id="site" name="site" value="<?php echo(isset($plugins->site)?$plugins->site:''); ?>" disabled="disabled" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
                                                
											</div>
                                            
											<div class="box-footer">
												<button type="submit" <?php echo ( ($plugins->type_plugin != 'section') ? 'disabled="disabled"' :'' ); ?> class="btn btn-primary"><a href="#" onclick="installSection('<?php echo ($id) ?>');" >Install</a></button>
											</div>			
                                            		
										</form>
									</div><!-- /.box-body -->
								
							</div><!-- /.tab-pane -->
							
							<div class="tab-pane" id="tab_2">							
								<!-- general form elements disabled -->
									<div class="box-body">
										<form role="form" method="post">
											<input type="hidden" name="act" value="tab_2" />
											<!--<div class="box">
												<div class="box-body table-responsive no-padding">
													<table class="table table-striped">
														<tr>
															<th>Area Name</th>
															<th>Status</th>
														</tr> -->
														<?php foreach($area as $a){ ?>
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <div class="box">
                                                                        <div class="box-header">
                                                                            <h3 class="box-title"><?php echo($a['display_name']); ?></h3>
                                                                        </div><!-- /.box-header -->
                                                                        <div class="box-body table-responsive no-padding">
                                                                            <table class="table table-hover">
                                                                                <tr>
                                                                                    <th>Area Name</th>
                                                                                    <th><?php echo ( (($PUBLISH) ? 'Status' : '') ); ?></th>
                                                                                </tr>
                                                                                <tr>
																                    <input type="hidden" name="plugin_area[<?php echo($a['id']); ?>][0][enable]" value="0" />
																                    <td class="col-md-8"><?php echo($a['display_name']); ?></td>
																                    <td class="col-md-4"><input type="checkbox" id="selecctall_<?php echo($a['id']); ?>" name="plugin_area[<?php echo($a['id']); ?>][0][enable]" class="check_wid sel_<?php echo ($a['id']); ?>" <?php echo(isset($plugins->plugin_area) && (isset($plugins->plugin_area[$a['id']][0]) && $plugins->plugin_area[$a['id']][0]['enable'] == 1  )?'checked="checked"':''); ?> value="1" <?php echo (($plugins->status == '1') ? '' : 'disabled="disabled"') ?> onchange="ChangeForm();"/></td>                                                                                    
                                                                                </tr>
                                        										<?php 
                                                            						if(sizeof($a['sub_area'])>0) 
                                                            						{
                                                            							foreach($a['sub_area'] as $a_sub)
                                                            							{  ?>
                                                                                            <tr>
                                																<input type="hidden" name="plugin_area[<?php echo($a['id']); ?>][<?php echo($a_sub['id']); ?>][enable]" value="0" />
                                																<td class="col-md-8"><?php echo( '['.$a['display_name'].'] - '.$a_sub['name']); ?></td>
                                																<td class="col-md-4"><input type="checkbox" name="plugin_area[<?php echo($a['id']); ?>][<?php echo($a_sub['id']); ?>][enable]" class="check_wid sel_<?php echo ($a['id']); ?>" <?php echo(isset($plugins->plugin_area) && ( isset($plugins->plugin_area[$a['id']][$a_sub['id']]) && $plugins->plugin_area[$a['id']][$a_sub['id']]['enable'] == 1 )?'checked="checked"':''); ?> value="1" <?php echo (($plugins->status == '1') ? '' : 'disabled="disabled"') ?> onchange="ChangeForm();"/></td>
                                															</tr>
                                        										<?php } }  ?>                                        
                                                                            </table>
                                                                        </div><!-- /.box-body -->
                                                                    </div><!-- /.box -->
                                                                </div>
                                                            </div>
														    <?php  } ?> <!--
													</table>
												</div><!-- /.box-body -->
											<!-- </div><!-- /.box -->
											
											<div class="box-footer">
												<button type="submit" class="btn btn-primary">Submit</button>
											</div>			
										</form>
									</div><!-- /.box-body -->
									
							</div><!-- /.tab-pane -->
                            
                            <?php if(file_exists(PLUGIN_PATH.$plugins->name.'/settings.php')){ ?>
                            
							<div class="tab-pane" id="tab_3">							
								<!-- general form elements disabled -->
									<div class="box-body">
										<form role="form" method="post">
											<input type="hidden" name="act" value="tab_3" />
                                            
                                            <?php include(PLUGIN_PATH.$plugins->name.'/settings.php'); ?>
                                            
											<div class="box-footer">
												<button type="submit" class="btn btn-primary">ok</button>
											</div>			
										</form>
									</div><!-- /.box-body -->
									
							</div><!-- /.tab-pane -->
                            
                            <?php } ?>
                                                        
						</div><!-- /.tab-content -->
					</div><!-- nav-tabs-custom -->
							
<!-- END PAGE -->
<?php include_once('footer.php')?>