<?php 

include_once(dirname(__FILE__).'/config/include.php');

$sezione = new Sezioni($db);

if(isset($id)) {
	
	if(!$sezione->getSezione($id)){
		header('Location: sezioni.php?resp_code=615');
		exit ();
	}
		
}

if(isset($_POST["act"]) && $_POST["act"]=='save') {
	$res = false;

	if(isset($_POST['display_name']) && trim($_POST['display_name'])!=''){
		$sezione->display_name 			= $_POST['display_name'];
	}
	else
	{	
		$errors[] 						= "Devi inserire un display_name";
	}

	if(isset($_POST['area_name']) && trim($_POST['area_name'])!=''){
		$sezione->area_name 			=  $_POST['area_name'];
        $sezione->pagina_sub 			=  $_POST['area_name'];
	}
	else
	{	
		$errors[] 						= "Devi inserire un area_name";
	}
	
	if(isset($_POST['title']) && trim($_POST['title'])!=''){
		$sezione->title 			=  $_POST['title'];
	}
	else
	{	
		$errors[] 						= "Devi inserire una descrizione";
	}
	
	if(isset($_POST['icon_sezione']) && trim($_POST['icon_sezione'])!=''){
		$sezione->img 					=  $_POST['icon_sezione'];
	}
	else
	{	
		$errors[] 						= "Devi inserire un'immagine";
	}
		
	$sezione->created_by                 = $_SESSION['dashboard_iduser'];
		
	if(sizeof($errors)==0) {
		$ret = false;	
		if( $id > 0 ){ //update
		
			$res = $sezione->Update($debug);
			if($res) {
				$resp_code 			= 110;
				$ret				= Log::Insert($db,2,8,$_SESSION['dashboard_iduser'],$id,'Modifica sezioni');
			} else {
				$resp_code 			= 115;	
			}
	
		}else { //insert
		
			$res = $sezione->Insert();
			
			if($res) {
				$resp_code 			= 100;
				$ret				= Log::Insert($db,1,8,$_SESSION['dashboard_iduser'],$sezione->id,'Creazione sezioni');
			} else {
				$resp_code 			= 105;	
			}
		
		}

		if($ret) {
			header('Location: sezioni-edit.php?id='.$sezione->id.'&resp_code='.$resp_code);
			exit ();
		} else {
			$resp_code 				= 635;
		}
	}
}


if(isset($_POST["act"]) && $_POST["act"]=='save_sub') {

	$res = false;

	if(isset($_POST['section_name']) && trim($_POST['section_name'])!=''){
		$sezione->titolo_sub			= $_POST['section_name'];
	}else{
		
		$errors[] = "Devi inserire un nome";
		$active_tab="#tab2";
		$linguetta="#lin_sub_sezioni";
		
		}
		
	if(isset($_POST['page']) && trim($_POST['page'])!=''){
		$sezione->pagina_sub=$_POST['page'];
	}else{
		
		$errors[] = "Devi inserire la pagina";
		$active_tab="#tab2";
		$linguetta="#lin_sub_sezioni";
	
	}
	

	if(sizeof($errors)==0) {
		if($id>0){
			
			$res = $sezione->insert_sub();
			if($res) {
				$resp_code 			= 100;
				$ret					= Log::Insert($db,2,2,$_SESSION['dashboard_iduser'],$id,'Inserimento sub sezione');
			} else {
				$resp_code			= 105;	
			}
		}
	
		if($ret) {			
			header('Location: sezioni-edit.php?id='.$sezione->id.'&resp_code='.$resp_code);
			exit ();
		} else {
			$active_tab				= "#tab2";
			$linguetta				= "#lin_sub_sezioni";
			$resp_code				= 635;
		}
	}

}


if(isset($_POST["act"]) && $_POST["act"]=='save_element') {

	$res = false;

	if(isset($_POST['nome_elem']) && trim($_POST['nome_elem'])!=''){
		$sezione->nome_elem				= $_POST['nome_elem'];
	}else{
		
		$errors[] = "Devi inserire un nome";
		$active_tab="#tab3";
		$linguetta="#lin_elementi";
		
	}
		
	if(isset($_POST['tipo_elem']) && trim($_POST['tipo_elem'])!=''){
		$sezione->tipo_elem				= $_POST['tipo_elem'];
	}else{
		
		$errors[] = "Devi inserire un tipo";
		$active_tab="#tab3";
		$linguetta="#lin_elementi";
	
	}
	

	if(sizeof($errors)==0) {
		if($id>0){
			
			$res = $sezione->insert_elementi();
			if($res) {
				$resp_code 			= 100;
				$ret					= Log::Insert($db,2,2,$_SESSION['dashboard_iduser'],$id,'Inserimento elementi sezione');
			} else {
				$resp_code			= 105;
			}
		}
	
		if($ret) {			
			header('Location: sezioni-edit.php?id='.$sezione->id.'&resp_code='.$resp_code);
			exit ();
		}
		else {
			$active_tab				= "#tab3";
			$linguetta				= "#lin_elementi";
			$resp_code				= 635;
		}
	}

}

if(isset($_POST["act"]) && $_POST["act"]=='gen') {

	$res = false;

	if(isset($_POST['tipo_db']) && trim($_POST['tipo_db'])!=''){
		$sezione->tipo_db=$_POST['tipo_db'];
	}else{
		
		$errors[] = "Devi inserire un tipo di sql";
		$active_tab="#tab4";
		$linguetta="#lin_gen_sezioni";
		
	}
		
	/*if(isset($_POST['database']) && trim($_POST['database'])!=''){
		$sezione->database	= $_POST['database'];
	}else{
		
		$errors[] = "Devi inserire il nome del database";
		$active_tab="#tab4";
		$linguetta="#lin_gen_sezioni";
	
	}*/
		
	if(isset($_POST['default']) && trim($_POST['default'])!=''){
		$sezione->default_tbl	= $_POST['default'];
	}else{
		$sezione->default_tbl	= 'false';	
	}
		
	if(isset($_POST['allegati']) && trim($_POST['allegati'])!=''){
		$sezione->allegati		= $_POST['allegati'];
	}else{
		$sezione->allegati		= 'false';	
	}
		
	if(isset($_POST['gallery']) && trim($_POST['gallery'])!=''){
		$sezione->gallery		= $_POST['gallery'];
	}else{
		$sezione->gallery		= 'false';	
	}
		
	if(isset($_POST['ordinamento']) && trim($_POST['ordinamento'])!=''){
		$sezione->ordinamento	= $_POST['ordinamento'];
	}else{
		$sezione->ordinamento	= 'false';	
	}
		
	/*if(isset($_POST['nome_el']) && sizeof($_POST['nome_el'])>0){
		$sezione->nome_el=$_POST['nome_el'];
	}

	
	if(isset($_POST['tipo_el']) && sizeof($_POST['tipo_el'])>0){
		$sezione->tipo_el = $_POST['tipo_el'];
	}*/
	
	
		
	if(isset($_POST['prefisso_database']) && trim($_POST['prefisso_database'])!=''){
		$sezione->prefisso_database=$_POST['prefisso_database'];
	}
	
	if(sizeof($errors)==0) {
		if($id>0){
			
			$res = $sezione->insert_info_sezione(true); //gen_sez();
			if($res) {
				$resp_code 			= 100;
				$ret				= Log::Insert($db,2,2,$_SESSION['dashboard_iduser'],$id,'generazione sezione');
			} else {
				$resp_code			= 105;
			}
		}
	
		if($ret) {			
			header('Location: sezioni-edit.php?id='.$sezione->id.'&resp_code='.$resp_code);
			exit ();
		}
		else {
			$active_tab				= "#tab4";
			$linguetta				= "#lin_gen_sezioni";
			$resp_code				= 635;
		}
	}

}

if(isset($_GET["delete_sub"]) && trim($_GET["delete_sub"])!="" && is_numeric($_GET["delete_sub"]) && $user->CheckPermessi($_SESSION['dashboard_iduser'], $area[0]['area_name'],NULL,NULL,true)) {
	if(Sezione::DeleteSub($db, $_GET["delete_sub"])) {
		$resp_code = 140;
		header('Location: sezioni-edit.php?id='.$id.'&resp_code='.$resp_code);
		exit ();
	}else{
		$resp_code = 145;
		header('Location: sezioni-edit.php?id='.$id.'&resp_code='.$resp_code);
		exit ();
		}
}

if(isset($_GET["delete_elem"]) && trim($_GET["delete_elem"])!="" && is_numeric($_GET["delete_elem"]) && $user->CheckPermessi($_SESSION['dashboard_iduser'], $area[0]['area_name'],NULL,NULL,true)) {
	if(Sezione::DeleteElem($db, $_GET["delete_elem"])) {
		$resp_code = 140;
		header('Location: sezioni-edit.php?id='.$id.'&resp_code='.$resp_code);
		exit ();
	}else{
		$resp_code = 145;
		header('Location: sezioni-edit.php?id='.$id.'&resp_code='.$resp_code);
		exit ();
		}
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo (NOME_PRJ); ?> | <?php echo($area['title']); ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		    
		<?php include_once(THEME.'/include/lib_js.php'); ?>
        <?php include_once(DASHBOARD_PATH.'js/script/operation.php'); ?>
		
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
                	<div Class="nav-tabs-custom">
                		<ul Class="nav nav-tabs">
                			<li onclick="ChangeTabs('tab_1');" Class="active"><a href="#tab_1" data-toggle="tab">Section</a></li>
                			<li <?php if(isset($id)) { ?> onclick="ChangeTabs('tab_2');" <?php } else { ?> Class="disabled" <?php } ?> ><a href="#tab_2" <?php if(isset($id)) { ?> data-toggle="tab" <?php } ?>>Sub Section</a></li>
                		</ul>
                		<div Class="tab-content">
                			<div Class="tab-pane active" id="tab_1">
                				<!-- general form elements disabled -->
                                <div Class="box-body">
                                    <form role="form" method="post">
                                        <input type="hidden" name="act" value="save" />                
                                    											
                        				<div Class="form-group">
                        					<label for="display_name">Display name</label>
                                                
                                            <div Class="input-group">
                        						
                                                <span Class="input-group-addon"><i Class="fa fa-envelope"></i></span>
                                                <input type="text" Class="form-control" placeholder="Display name" id="display_name" name="display_name" value="<?php echo(isset($sezione->display_name)?$sezione->display_name:''); ?>" onchange="ChangeForm();">
                                            </div>
                                        </div>
                                    											
                        				<div Class="form-group">
                        					<label for="area_name">Area Code</label>
                                                
                                            <div Class="input-group">
                        						
                                                <span Class="input-group-addon"><i Class="fa fa-envelope"></i></span>
                                                <input type="text" Class="form-control" placeholder="Area Code" id="area_name" name="area_name" value="<?php echo(isset($sezione->area_name)?$sezione->area_name:''); ?>" onchange="ChangeForm();">
                                            </div>
                                        </div>
                                    											
                        				<div Class="form-group">
                        					<label for="display_name">Description</label>
                                                
                                            <div Class="input-group">
                        						
                                                <span Class="input-group-addon"><i Class="fa fa-envelope"></i></span>
                                                <input type="text" Class="form-control" placeholder="Description" id="title" name="title" value="<?php echo(isset($sezione->title)?$sezione->title:''); ?>" onchange="ChangeForm();">
                                            </div>
                                        </div>
                                    											
                        				<div Class="form-group">
                        					<label for="icon_sezione">Icon</label>
                                                
                                            <div Class="input-group">
                        						
                                                <span Class="input-group-addon"><i Class="fa fa-envelope"></i></span>
                                                <input type="text" Class="form-control" placeholder="Icon" id="icon_sezione" name="icon_sezione" value="<?php echo(isset($sezione->img)?$sezione->img:''); ?>" onchange="ChangeForm();">
                                            </div>
                                        </div>                    			
                                                                
                    					<div Class="box-footer">
                    						<button type="submit" Class="btn btn-primary">Submit</button>
                    					</div>			
                    				</form>
                    			</div><!-- /.box-body -->
                    			
                    		</div><!-- /.tab-pane -->
                		
                		<div Class="tab-pane" id="tab_2">							
                			<!-- general form elements disabled -->
                				<div Class="box-body">
                					<form role="form" method="post">
                						<input type="hidden" name="act" value="save_sub" onchange="ChangeForm();"/>
                                                            											
                        				<div Class="form-group">
                        					<label for="section_name">Section name</label>
                                                
                                            <div Class="input-group">
                        						
                                                <span Class="input-group-addon"><i Class="fa fa-envelope"></i></span>
                                                <input type="text" Class="form-control" placeholder="Icon" id="section_name" name="section_name" value="<?php echo(isset($sezione->titolo_sub)?$sezione->titolo_sub:''); ?>" onchange="ChangeForm();">
                                            </div>
                                        </div>     
                                        
                        				<div Class="form-group">
                        					<label for="page">Page</label>
                                                
                                            <div Class="input-group">
                        						
                                                <span Class="input-group-addon"><i Class="fa fa-envelope"></i></span>
                                                <input type="text" Class="form-control" placeholder="page" id="page" name="page" value="<?php echo(isset($sezione->pagina_sub)?$sezione->pagina_sub:''); ?>" onchange="ChangeForm();">
                                            </div>
                                        </div>    
                                                  			
                                                                
                    					<div Class="box-footer">
                    						<button type="submit" Class="btn btn-primary">Submit</button>
                    					</div>
                                        	
                					</form>                        
                                </div><!-- /.box-body -->
                                
                						<?php if(sizeof($sezione->sub)>0) { ?>
                                        
                						<table width="100%" cellspacing="0">
                							<thead>
                								<tr>
                									<th>Icona</th>
                									<th>Nome</th>
                									<th><?php echo ($permits->CheckPermessi($_SESSION['dashboard_iduser'], 'SEZIONI', DELETE, $area_sub->pagina, '', '','')); ?></th>
                								</tr>
                							</thead>
                							<tbody>
                								<?php foreach ($sezione->sub as $n) {?>
                								<tr>
                									<td><span Class="<?php echo ($n['img']); ?>"></span></td>
                									<td><?php echo ($n['name']); ?></td>
                									<td style="line-height: 45px;"><?php echo ($permits->CheckPermessi($_SESSION['dashboard_iduser'], 'SEZIONI', DELETE, $area_sub->pagina, $n['id'], 'glyphicon glyphicon-trash', 'button')); ?></td>
                								</tr>
                								<?php } ?>
                							</tbody>
                						</table>
                						<?php }
                			else {
                			?>
                						<div Class="fs13 nero bold uppercase tab_title" style="margin-bottom:10px;">nessun elemento presente</div>
                						<?php
                			} ?>
                            
                    			
                    		</div><!-- /.tab-pane -->
            
						</div><!-- /.tab-content -->
					</div><!-- nav-tabs-custom -->
					
<!-- END PAGE -->
<?php include_once('footer.php')?>