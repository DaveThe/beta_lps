<?php 
namespace Dashboard;
include_once(dirname(__FILE__).'/config/include.php');
//include_once('class_secret.php');
$sec		= new Secret();
	
$element = new $Dashboard_user($db); //$Dashboard_user;
if(isset($id)) 
{
	if(!$element->GetElement($id))
    {
		header('Location: '. strtolower(PAGE_NAME).'_list.php?resp_code=615');
		exit ();
	}	
    $elenco_aree = $element->getAllPermissions($id);
	if(!$elenco_aree)
    {
		//header('Location: '. strtolower(PAGE_NAME).'_list.php?resp_code=615');
		exit ();
	}	
}
//$ParametersList['menu'] = false;
//$elenco_aree = Sezioni::GetElementsList($ParametersList);

if(isset($_POST["act"]) && $_POST["act"]=='tab_1') 
{
	$res 		= false;
	$active_tab	= $_POST["act"];

	if(isset($_POST['username']) && trim($_POST['username'])!='')
    {
		$element->username 			=  $_POST['username'];
	}
	else
	{	
		$errors[] 					= "Devi inserire uno username";
	}

	if(isset($_POST['password']) && trim($_POST['password'])!='' && preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $_POST['password'])){
		
		if( isset($_POST['conferma_password']) && $_POST['password'] == $_POST['conferma_password'] ){
			$element->password 		= $_POST['password'];
		}else{
			$errors[] 				= "Le password non coincidono";
		}
		
	}
	else {
		$errors[] 					= "Devi inserire una password compresa tra gli 8 e i 20 caratteri, con una maiuscola e un numero";
	}

	if(isset($_POST['email']) && trim($_POST['email'])!='' && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
		$element->email 			=  $_POST['email'];
	}
	else
	{	
		$errors[] 					= "Devi inserire una Mail valida";
	}
    
    if(isset($_POST['gender']) && trim($_POST['gender']) != '')
    {
	   $element->gender 				    = $_POST['gender'];	
	}
	else
	{	
		$errors[] 					= "Devi dirmi se sei Uomo o Donna o altro";
	}

	if(isset($_POST['avatar']) && trim($_POST['avatar']) != '')
    {
	   $element->img 				    = $_POST['avatar'];	
	}
	else
	{	
        if($element->gender == 0 )
        {
            $element->img                = 'avatar5.png';
        }
        else if($element->gender == 1)
        {
            $element->img                = 'avatar3.png';
        }
        else
        {
            $element->img                = 'avatar2.png';
        }
		
	}
    
	$element->nickname 				= $_POST['nickname'];
	$element->prj_color 				= $_POST['prj_color'];
	$element->company 				= $_POST['company'];
	$element->created_by 				= $_SESSION['dashboard_iduser'];
		
	if(sizeof($errors)==0) {
		$ret = false;
		if($id>0){ //update
		
			$res 		= $element->Update();
			
			if($res){
				$resp_code	= 410;
                
                $action     = new LogAction($db, UPDATE, __FUNCTION__, __CLASS__, basename(__FILE__), $id, ID_USER_LOG);                            
                $ret		= $action->Insert();
                
			} else {
				$resp_code	= 415;	
			}
			
		} else { //insert
		
			$res 		= $element->Insert();
			$resp_code	= 10;
			
			if($res){
				$resp_code	= 400;
                
                $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $id, ID_USER_LOG);                           
                $ret		= $action->Insert();
			} else {
				$resp_code	= 405;	
			}
			
		}
        
		if($ret) {
			header('Location: user_edit.php?id='.$element->id.'&resp_code='.$resp_code.'&tab='.$_POST["act"]);
			exit ();
		} else {
			$resp_code 				= 635;
		}
	}
}

if(isset($_POST["act"]) && $_POST["act"]=='tab_2') {
	
	$res 		= false;
	$active_tab	= $_POST["act"];
	//var_dump($_POST['permission']);
	if(isset($_POST['permission']) && is_array($_POST['permission'])){
        
		//$temp_permessi				= array();
		$temp_permessi				= $_POST['permission'];
		
        /**************************STAMPA CONTROLLO*******************************/
        /*
		foreach($_POST['permission'] as $key=>$value){
			
            foreach($_POST['permission'][$key] as $key2=>$value2){
                echo ' -- id_area '.$key.' -- id_sub '.$key2.' => ';
                echo $value2['read'].' - ';
                echo $value2['write'].' - ';
                echo $value2['delete'].' - ';
                echo $value2['publish'].' - ';
                echo $value2['owned'].' - <br>';    
            }
         }
         */
         /**************************STAMPA CONTROLLO*******************************/ 
         
         
         /**************************CONTROLLO*******************************/
		foreach($temp_permessi as $key=>$value){
            foreach($temp_permessi[$key] as $key2=>$value2){
                if( isset($value2['read']) && ($value2['read']==1 || $value2['read']==0) ){}else{
					$errors[] 						= "Dati inviati non corretti";
				}
                if( isset($value2['write']) && ($value2['write']==1 || $value2['write']==0) ){}else{
					$errors[] 						= "Dati inviati non corretti";
				}
                if( isset($value2['delete']) && ($value2['delete']==1 || $value2['delete']==0) ){}else{
					$errors[] 						= "Dati inviati non corretti";
				}
                if( isset($value2['publish']) && ($value2['publish']==1 || $value2['publish']==0) ){}else{
					$errors[] 						= "Dati inviati non corretti";
				}
                if( isset($value2['owned']) && ($value2['owned']==1 || $value2['owned']==0) ){}else{
					$errors[] 						= "Dati inviati non corretti";
				}                  
            }
         }   
         /**************************CONTROLLO*******************************/
             
        
		$element->permissions							= $temp_permessi;
		$element->id                                    = $id;
	}else{
		$errors[] = "Dati inviati non corretti";		
	}
	

	if(sizeof($errors)==0) {
		 
		if($id>0){ //update
            
            $ret = false;
			$res 		= $element->InsertPermissions();			
						
			if($res){
				$resp_code	= 510;
    				
                $action     = new LogAction($db, UPDATE, __FUNCTION__, __CLASS__, basename(__FILE__), $id, ID_USER_LOG);                            
                $ret		= $action->Insert();        	
			} 
            else 
            {
			   
				$resp_code	= 515;
			}
                
    		if($ret) 
            {
    			header('Location: user_edit.php?id='.$element->id.'&resp_code='.$resp_code.'&tab='.$_POST["act"]);
    			exit ();
    		} 
            else 
            {
    			$resp_code 				= 635;
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
				
		<?php /* <script type = "text/javascript">$(document).ready(function(){ ChangeTabs('<?php echo ( $active_tab ); ?>'); });</script> */ ?>
		
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
							<li onclick="ChangeTabs('tab_1');" class="active"><a href="#tab_1" data-toggle="tab">User Data</a></li>
							<li <?php if(isset($id)) { ?> onclick="ChangeTabs('tab_2');" <?php } else { ?> class="disabled" <?php } ?> ><a href="#tab_2" <?php if(isset($id)) { ?> data-toggle="tab" <?php } ?>>Permission</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<!-- general form elements disabled -->

									<div class="box-body">
										<form role="form" method="post">
										
											<input type="hidden" name="act" value="tab_1" />
                                            
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
                                                        
                                                        <?php /*
                                                        <div class="col-md-8">
                                                            
        													 if(isset($_SESSION['dashboard_iduser']) && $_SESSION['dashboard_iduser']==1) {?>
        														<input type="text" name="avatar" id="avatar" value="<?php echo(isset($element->img)?$element->img:''); ?>" />
        													<?php }	else {?>
        														<input type="hidden" name="avatar" id="avatar" value="<?php echo(isset($element->img)?$element->img:''); ?>" />
        													<?php } 
                                                        </div>
                                                        
                                                        <div class="col-md-4">
                                                            <button name="img_upload" type="button" id="upload_btn" class="btn btn-info">carica</button>
                                                        </div>*/?>
    												</div>
    											</div>	
                                            
                                            </div>
                                            
                                            
                                            <div class="col-sm-9">
                                                                                                			
    											<div class="form-group">
    												<label for="nickname">Nickname</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" placeholder="Nickname" id="nickname" name="nickname" value="<?php echo(isset($element->nickname)?$element->nickname:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>	
                											
    											<div class="form-group">
    												<label for="prj_color">Skin</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-tint"></i></span>
        												<select class="form-control" id="prj_color" name="prj_color">
        													<option value="blue" <?php echo ( ( isset($element->prj_color) && $element->prj_color == 'blue' ) ? 'selected="selected"': '' ); ?> >Blue</option>
                                                            <option value="black" <?php echo ( ( isset($element->prj_color) && $element->prj_color == 'black' ) ? 'selected="selected"': '' ); ?> >Black</option>
                                                            <option value="red" <?php echo ( ( isset($element->prj_color) && $element->prj_color == 'red' ) ? 'selected="selected"': '' ); ?> >Red</option>
                                                            <option value="yellow" <?php echo ( ( isset($element->prj_color) && $element->prj_color == 'yellow' ) ? 'selected="selected"': '' ); ?> >Yellow</option>
                                                            <option value="purple" <?php echo ( ( isset($element->prj_color) && $element->prj_color == 'purple' ) ? 'selected="selected"': '' ); ?> >Purple</option>
                                                            <option value="green" <?php echo ( ( isset($element->prj_color) && $element->prj_color == 'green' ) ? 'selected="selected"': '' ); ?> >Green</option>
                                                            <option value="blue-light" <?php echo ( ( isset($element->prj_color) && $element->prj_color == 'blue-light' ) ? 'selected="selected"': '' ); ?> >Blue-light</option>
                                                            <option value="black-light" <?php echo ( ( isset($element->prj_color) && $element->prj_color == 'black-light' ) ? 'selected="selected"': '' ); ?> >Black-light</option>
                                                            <option value="red-light" <?php echo ( ( isset($element->prj_color) && $element->prj_color == 'red-light' ) ? 'selected="selected"': '' ); ?> >Red-light</option>
                                                            <option value="yellow-light" <?php echo ( ( isset($element->prj_color) && $element->prj_color == 'yellow-light' ) ? 'selected="selected"': '' ); ?> >Yellow-light</option>
                                                            <option value="purple-light" <?php echo ( ( isset($element->prj_color) && $element->prj_color == 'purple-light' ) ? 'selected="selected"': '' ); ?> >Purple-light</option>
                                                            <option value="green-light" <?php echo ( ( isset($element->prj_color) && $element->prj_color == 'green-light' ) ? 'selected="selected"': '' ); ?> >Green-light</option>

        												</select>                                                        
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
    												<label for="email">Email address</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                        <input type="text" class="form-control" placeholder="Email" id="email" name="email" value="<?php echo(isset($element->email)?$element->email:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="company">Company</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                                        <input type="text" class="form-control" placeholder="Company" id="company" name="company" value="<?php echo(isset($element->company)?$element->company:''); ?>" onchange="ChangeForm();">
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
                                                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="<?php echo(isset($element->password)? base64_decode( $sec->decript($element->password) ) :''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                </div>
                                                			
    											<div class="form-group">
    												<label for="conferma_password">Confirm Password</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                        <input type="password" class="form-control" placeholder="Confirm Password" id="conferma_password" name="conferma_password" value="<?php echo(isset($element->password)? base64_decode( $sec->decript($element->password) ) :''); ?>" onchange="ChangeForm();">
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
											<div class="box">
												<div class="box-body table-responsive no-padding">
													<table class="table table-striped">
														<tr>
															<th>Area</th>
															<th>Allow All</th>
															<th>Read</th>
															<th>Write/Edit</th>
															<th>Delete</th>
															<th>Publish</th>
															<th>Own only</th>
														</tr>
														<?php foreach($elenco_aree as $a){ ?>
															<tr>
																<input type="hidden" name="permessi[<?php echo($a['area_name']); ?>][id_area]" value="<?php echo($a['id_area']); ?>" />
																<td><?php echo((isset($a['sub_area']) ? '['.$a['display_name'].'] - '.$a['sub_area'] : $a['display_name'] )); ?></td>
                                                                <?php // if(isset($a['sub_area']) ) { ?>
                                                                <td><input type="checkbox" id="selecctall_<?php echo($a['id_area']); ?>" class="check_wid sel_<?php echo ($a['id_area']); ?>" <?php echo( (($a['read_p_area']==1) && ($a['write_p_area']==1) && ($a['delete_p_area']==1) && ($a['publish_p_area']==1) && ($a['owned_p_area']!=1))?'checked="checked"':''); ?> value="1" onchange="ChangeForm();"/></td>
																<td>
                                                                    <input type="hidden" name="permission[<?php echo($a['id_area']); ?>][<?php echo( (isset($a['id_sub']) ? $a['id_sub'] : '0') ); ?>][read]" value="0" />
                                                                    <input type="checkbox" name="permission[<?php echo($a['id_area']); ?>][<?php echo( (isset($a['id_sub']) ? $a['id_sub'] : '0') ); ?>][read]" class="check_wid sel_<?php echo ($a['id_area']); ?>" <?php echo( ($a['read_p_area'])==1?'checked="checked"':''); ?> value="1" onchange="ChangeForm();"/>
                                                                </td>
																<td>
                                                                    <input type="hidden" name="permission[<?php echo($a['id_area']); ?>][<?php echo( (isset($a['id_sub']) ? $a['id_sub'] : '0') ); ?>][write]" value="0" />
                                                                    <input type="checkbox" name="permission[<?php echo($a['id_area']); ?>][<?php echo( (isset($a['id_sub']) ? $a['id_sub'] : '0') ); ?>][write]" class="check_wid sel_<?php echo ($a['id_area']); ?>" <?php echo( ($a['write_p_area'])==1?'checked="checked"':''); ?> value="1" onchange="ChangeForm();"/>
                                                                </td>
																<td>
                                                                    <input type="hidden" name="permission[<?php echo($a['id_area']); ?>][<?php echo( (isset($a['id_sub']) ? $a['id_sub'] : '0') ); ?>][delete]" value="0" />
                                                                    <input type="checkbox" name="permission[<?php echo($a['id_area']); ?>][<?php echo( (isset($a['id_sub']) ? $a['id_sub'] : '0') ); ?>][delete]" class="check_wid sel_<?php echo ($a['id_area']); ?>" <?php echo( ($a['delete_p_area'])==1?'checked="checked"':''); ?>value="1" onchange="ChangeForm();"/>
                                                                </td>
																<td>
                                                                    <input type="hidden" name="permission[<?php echo($a['id_area']); ?>][<?php echo( (isset($a['id_sub']) ? $a['id_sub'] : '0') ); ?>][publish]" value="0" />
                                                                    <input type="checkbox" name="permission[<?php echo($a['id_area']); ?>][<?php echo( (isset($a['id_sub']) ? $a['id_sub'] : '0') ); ?>][publish]" class="check_wid sel_<?php echo ($a['id_area']); ?>" <?php echo( ($a['publish_p_area'])==1?'checked="checked"':''); ?> value="1" onchange="ChangeForm();"/>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="permission[<?php echo($a['id_area']); ?>][<?php echo( (isset($a['id_sub']) ? $a['id_sub'] : '0') ); ?>][owned]" value="0" />
                                                                    <input type="checkbox" name="permission[<?php echo($a['id_area']); ?>][<?php echo( (isset($a['id_sub']) ? $a['id_sub'] : '0') ); ?>][owned]" class="check_wid sel_<?php echo ($a['id_area']); ?>" <?php echo( ($a['owned_p_area'])==1?'checked="checked"':''); ?> value="1" onchange="ChangeForm();"/>
                                                                </td>
                                                                
															    <?php /* } else { ?>
                                                                
                                                                <td><input type="checkbox" class="check_wid" <?php echo( (($a['read_p_area']==1) && ($a['write_p_area']==1) && ($a['delete_p_area']==1) && ($a['publish_p_area']==1) && ($a['owned_p_area']!=1))?'checked="checked"':''); ?> value="1" onchange="ChangeForm();"/></td>
                                                                <td>
                                                                    <input type="hidden" name="permission[<?php echo($a['id_area']); ?>][0][read]" value="0" />
                                                                    <input type="checkbox" name="permission[<?php echo($a['id_area']); ?>][0][read]" class="check_wid" <?php echo( ($a['read_p_area'])==1?'checked="checked"':''); ?> value="1" onchange="ChangeForm();"/>
                                                                </td>
																<td>
                                                                    <input type="hidden" name="permission[<?php echo($a['id_area']); ?>][0][write]" value="0" />
                                                                    <input type="checkbox" name="permission[<?php echo($a['id_area']); ?>][0][write]" class="check_wid" <?php echo( ($a['write_p_area'])==1?'checked="checked"':''); ?> value="1" onchange="ChangeForm();"/>
                                                                </td>
																<td>
                                                                    <input type="hidden" name="permission[<?php echo($a['id_area']); ?>][0][delete]" value="0" />
                                                                    <input type="checkbox" name="permission[<?php echo($a['id_area']); ?>][0][delete]" class="check_wid" <?php echo( ($a['delete_p_area'])==1?'checked="checked"':''); ?>value="1" onchange="ChangeForm();"/>
                                                                </td>
																<td>
                                                                    <input type="hidden" name="permission[<?php echo($a['id_area']); ?>][0][publish]" value="0" />
                                                                    <input type="checkbox" name="permission[<?php echo($a['id_area']); ?>][0][publish]" class="check_wid" <?php echo( ($a['publish_p_area'])==1?'checked="checked"':''); ?> value="1" onchange="ChangeForm();"/>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="permission[<?php echo($a['id_area']); ?>][0][owned]" value="0" />
                                                                    <input type="checkbox" name="permission[<?php echo($a['id_area']); ?>][0][owned]" class="check_wid" <?php echo( ($a['owned_p_area'])==1?'checked="checked"':''); ?> value="1" onchange="ChangeForm();"/>
                                                                </td>
															     <?php } */ ?>
                                                            </tr>
														<?php } ?>
													</table>
												</div><!-- /.box-body -->
											</div><!-- /.box -->
											
											<div class="box-footer">
												<button type="submit" class="btn btn-primary">Submit</button>
											</div>			
										</form>
									</div><!-- /.box-body -->
									
							</div><!-- /.tab-pane -->
						</div><!-- /.tab-content -->
					</div><!-- nav-tabs-custom -->
								

<!-- END PAGE -->
<?php include_once('footer.php')?>