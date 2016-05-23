<?php
namespace Dashboard;
include_once(dirname(__FILE__).'/config/include.php');

if(isset($_POST["act"]) && $_POST["act"] == 'save') {

	$res = false;
	
	if(isset($_POST['titolo']) && trim($_POST['titolo']) != '') {
		$settings->titolo 					= $_POST['titolo'];
	} else {
		$errors[] 							= "Devi inserire un titolo";
	}
	
	if(isset($_POST['sottotitolo']) && trim($_POST['sottotitolo']) != '') {
		$settings->sottotitolo 				= $_POST['sottotitolo'];
	}
	
	if(isset($_POST['testo']) && trim($_POST['testo']) != '') {
		$settings->testo 					= $_POST['testo'];
	} else {
		$errors[] 							= "Devi inserire un testo";
	}
	
	if(isset($_POST['date_input']) && trim($_POST['date_input']) != '') {
		$settings->data_pubblicazione 		= $_POST['date_input'];
	} else {
		$errors[] 							= "Devi inserire una data di pubblicazione valida";
	}
	
	if(isset($_POST['stato_GA']) && trim($_POST['stato_GA']) != '') {
		$settings->stato_GA 				= $_POST['stato_GA'];
	}else{
		$settings->stato_GA					= 'false';	
	}
	
    	
	if(isset($_POST['prj_color']) && trim($_POST['prj_color']) != '') {
		$Dashboard_user->prj_color		    = $_POST['prj_color'];
	} else {
		$errors[] 							= "Devi inserire il colore del sito";
	}
		
	if(isset($_POST['favicon']) && trim($_POST['favicon']) != '') {
		$settings->favicon				= $_POST['favicon'];
	} 
	
	if(isset($_POST['logo']) && trim($_POST['logo']) != '') {
		$settings->logo						= $_POST['logo'];
	} else {
		$errors[] 							= "Devi inserire un logo";
	}
	
	if($WRITE) {
		$settings->stato 					= 1;
	}
	
	$settings->created_by 					= $_SESSION['dashboard_iduser'];
	
	if(sizeof($errors) == 0) {
	
        $ret                    = false;
		$res        			= $settings->update();
					
		if($res) {
			$resp_code 			= 110;
			//$ret				= Log::Insert($db, 2, 2, $_SESSION['dashboard_iduser'], $id);
            $action     = new LogAction($db, UPDATE, __FUNCTION__, __CLASS__, basename(__FILE__), $settings->id, $settings->created_by, 'Modifica impostazioni dashboard');                            
            $ret		= $action->Insert();
             
            $res                = $Dashboard_user->update();
            
            if($res) {
    			$resp_code 		= 110;
    			//$ret			= Log::Insert($db, 2, 2, $_SESSION['dashboard_iduser'], $id, 'Modifica dettagli '.$area['title']);
    		} else {
    			$resp_code 		= 115;	
    		}
            
		} else {
			$resp_code 			= 115;	
		}
                			
		if($ret) {
			header('Location: settings_list.php?resp_code=' . $resp_code);
			exit ();
		} else {
			$resp_code 			= 635;
		}
	}
}	
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo (NOME_PRJ); ?> | <?php echo($area['title']); ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <?php include_once('resource.php'); ?>
		
<script type="text/javascript">

function cancCal(id) {
	document.getElementById(id).value='';
	}
 
 </script>
	</head>

    <body class="sidebar-mini skin-<?php echo ( $Dashboard_user->GetSkin() ); ?>-light ">
        
        <div class="wrapper">
        
		<?php include_once('header.php'); ?>
		        
		<?php include_once('menu_left.php'); ?>
            
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                
				<?php include_once('page_bar.php'); ?>
				
				<?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('alerts_callouts.php'); ?>
				
					
					<!-- Custom Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li onclick="ChangeTabs('tab_1');" class="active"><a href="#tab_1" data-toggle="tab">General Settings</a></li>
							<li onclick="ChangeTabs('tab_2');" ><a href="#tab_2" data-toggle="tab" >Developer</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<!-- general form elements disabled -->

									<div class="box-body">
										<form role="form" method="post">
											<input type="hidden" name="act" value="save" />
											
											<!-- text input -->
											<div class="form-group">
												<label>Title*</label>
												<input type="text" class="form-control" placeholder="Enter ..." name="titolo" value="<?php echo (isset($settings->titolo) ? str_replace('"', '&quot;', $settings->titolo) : ''); ?>" maxlength="200" onchange="ChangeForm();"/>
											</div>
											
											<!-- text input -->
											<div class="form-group">
												<label>Subtitle</label>
												<input type="text" class="form-control" placeholder="Enter ..." name="sottotitolo" value="<?php echo (isset($settings->sottotitolo) ? str_replace('"', '&quot;', $settings->sottotitolo) : ''); ?>" maxlength="200" onchange="ChangeForm();"/>
											</div>
											
											<!-- textarea -->
											<div class="form-group">
												<label>About us</label>
												<textarea class="form-control" rows="3" placeholder="Enter ..." name="testo" maxlength="200" onchange="ChangeForm();" id="editor1"><?php echo (isset($settings->testo) ? $settings->testo : ''); ?></textarea>
											</div>
											
											<!-- checkbox -->
											<div class="form-group">
												<div class="checkbox">
													<label>
														<input type="checkbox" name="stato_GA" value="true"/>
														Google Analytics*
													</label>
												</div>
											</div>
											
											<!-- text input 
											<div class="form-group">
												<label>Data pubblicazione progetto*</label>
												<input type="text" class="form-control" placeholder="Enter ..." id="date_input" name="date_input" value="<?php echo (isset($settings->data_pubblicazione) ? $settings->data_pubblicazione : ''); ?>" maxlength="200" onchange="ChangeForm();"/>
											</div>-->
                                            
                                            <!-- Date dd/mm/yyyy -->
                                            <div class="form-group">
                                                <label>Data pubblicazione progetto*:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" id="date_input" name="date_input" class="form-control" value="<?php echo (isset($settings->data_pubblicazione) ? $settings->data_pubblicazione : ''); ?>" onchange="ChangeForm();" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
											
											<!-- select -->
											<div class="form-group">
												<label>Skin sito</label>
												<select class="form-control" id="prj_color" name="prj_color">
													<option value="blue" <?php echo ( ( isset($Dashboard_user->prj_color) && $Dashboard_user->prj_color == 'blue' ) ? 'selected="selected"': '' ); ?> >Blue</option>
													<option value="black" <?php echo ( ( isset($Dashboard_user->prj_color) && $Dashboard_user->prj_color == 'black' ) ? 'selected="selected"': '' ); ?>>Black</option>
												</select>
											</div>	
																
											<div class="form-group">
												<label>favicon*</label>
												<div class="field"> 
													<img id="img_src" <?php echo(isset($settings->favicon) ? 'src="'.$config_upload["FAVICON"]["opzioni"]["dest_path"] . $settings->favicon .'"':''); ?> width="170" height="110" border="0" /><br />
													
													<button name="img_upload" type="button" id="upload_btn" class="btn btn-info">carica</button>
													
													<?php if(isset($_SESSION['dashboard_iduser']) && $_SESSION['dashboard_iduser']==1) {?>
														<input type="text" name="favicon" id="favicon" value="<?php echo(isset($settings->favicon)?$settings->favicon:''); ?>" />
													<?php }	else {?>
														<input type="hidden" name="favicon" id="favicon" value="<?php echo(isset($settings->favicon)?$settings->favicon:''); ?>" />
													<?php } ?>
												</div>
											</div>	
													
											<div class="form-group">
												<label>Logo*</label>
												<div class="field"> 
													<img id="img_src" <?php echo(isset($settings->logo) ? 'src="'.$config_upload["LOGO"]["opzioni"]["dest_path"] . $settings->logo .'"':''); ?> width="170" height="110" border="0" /><br />
													
													<button name="img_upload" type="button" id="upload_btn_2" class="btn btn-info">carica</button>
													
													<?php if(isset($_SESSION['dashboard_iduser']) && $_SESSION['dashboard_iduser']==1) {?>
														<input type="text" name="logo" id="logo" value="<?php echo(isset($settings->logo)?$settings->logo:''); ?>" />
													<?php }	else {?>
														<input type="hidden" name="logo" id="logo" value="<?php echo(isset($settings->logo)?$settings->logo:''); ?>" />
													<?php } ?>
												</div>
											</div>
								            
                                            <div class="MKU_IMG"></div>
                                            
											<div class="box-footer">
												<button type="submit" class="btn btn-primary">Submit</button>
											</div>
										</form>
									</div><!-- /.box-body -->
								
							</div><!-- /.tab-pane -->
							
							<div class="tab-pane" id="tab_2">							
								<!-- general form elements disabled -->
									<div class="box-body">

										<!-- text input -->
										<div class="form-group">
											<label>Debug KEY</label>
											<input type="text" class="form-control" value="<?php echo ( $debug_var->getKey() ); ?>" readonly/>
										</div>
								
										<!-- text input -->
										<div class="form-group">
											<label>API KEY</label>
											<input type="text" class="form-control" value="<?php echo ( 'Basic ' . base64_encode($Dashboard_user->username . ':' . $Dashboard_user->password) . '==' ); ?>" readonly/>
										</div>
								
										<!-- text input -->
										<div class="form-group">
											<label>PLUGIN KEY</label>
											<input type="text" class="form-control" value="<?php echo ( $plugins->getKey() ); ?>" readonly/>
										</div>
									</div><!-- /.box-body -->
									
							</div><!-- /.tab-pane -->
						</div><!-- /.tab-content -->
					</div><!-- nav-tabs-custom -->
                    
<!-- END PAGE -->
<?php include_once('footer.php')?>