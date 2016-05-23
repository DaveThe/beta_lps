<?php 
namespace Dashboard;

include_once(dirname(__FILE__).'/config/include.php');

$log = new Log($db);
if(isset($id)) 
{
	if(!$log->GetElement($id))
    {
		header('Location: log_list.php?resp_code=615');
		exit ();
	}	
}
include_once('operation_foo.php');

//$elenco_aree = Sezioni::GetArea($db,'', $_SESSION['dashboard_iduser']);

if(isset($_POST["act"]) && $_POST["act"]=='tab_2') {
	
	$res 		= false;
	$active_tab	= $_POST["act"];
	
	if(isset($_POST['plugin_area']) && is_array($_POST['plugin_area'])){

		$plugin_area				= array();
		$plugin_area				= $_POST['plugin_area'];
		//var_dump($_POST['plugin_area']);
        //exit();
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
        
		$log->plugin_area							= $plugin_area;
		
	}else{
		$errors[] = "Dati inviati non corretti";		
	}
	
    $log->created_by                                = $Dashboard_user->iduser;
    
	if(sizeof($errors)==0) {
		        
		if($id>0){ //update
			$res 		= $log->InsertAreaPlugin();			
						
			if($res){
				$resp_code	= 510;
    				
                $ret 		= Log::Insert($db,2,8,$_SESSION['dashboard_iduser'],$id,'Modifica permessi utente boffice');
                
        		if($ret) {
        			header('Location: plugin-edit.php?id='.$log->id.'&resp_code='.$resp_code.'&tab='.$_POST["act"]);
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
        <?php include_once('js/script/operation_js.php'); ?>	
				
	</head>


    <body class="sidebar-mini skin-<?php echo ( $Dashboard_user->GetSkin() ); ?>-light ">
        
        <div class="wrapper">
        
		<?php include_once('header.php'); ?>
		        
		<?php include_once('menu_left.php'); ?>
            
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                
				<?php include_once('page_bar.php'); ?>
				
				<?php if(sizeof($errors) > 0 || $respok !== false) include_once('alerts_callouts.php'); ?>
				
						<div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Log Panel</h3>
                                    </div><!-- /.box-header -->
                                        
                                    <span class="<?php echo ( ($log->error_type == '0') ? 'fa fa-warning text-warning' : 'fa fa-exclamation text-danger' ); ?>"> Log error</span>
                                                                        			
									<div class="form-group">
										<label>Error code</label>
                                        <input type="text" class="form-control" placeholder="description" id="description" name="description" value="<?php echo(isset($log->error_code)?$log->error_code:''); ?>" disabled="disabled" onchange="ChangeForm();">
                                    </div>
                                    			
									<div class="form-group">
										<label>Message</label>
                                        <textarea class="form-control" rows="3" placeholder="Error message" disabled=""><?php echo(isset($log->message)?$log->message:''); ?></textarea>                                        
                                    </div>
                                    			
									<div class="form-group">
										<label>Error File</label>
                                        <textarea class="form-control" rows="3" placeholder="Error message" disabled=""><?php echo(isset($log->error_file)?$log->error_file:''); ?></textarea>                                        
                                    </div>
                                   	
                                    <?php if($WRITE){ ?>
                                        <select class="form-control" id="error_type" name="error_type" onchange="changeStatus('<?php echo($log->status) ?>')">
        									<option value="0" <?php echo ( ( isset($log->status) && $log->status == "0" ) ? 'selected="selected"': "" ); ?> >Irrisolto</option>
        									<option value="1" <?php echo ( ( isset($log->status) && $log->status == "1" ) ? 'selected="selected"': "" ); ?>>Risolto</option>
        									<option value="2" <?php echo ( ( isset($log->status) && $log->status == "2" ) ? 'selected="selected"': "" ); ?>>In attesa</option>
        								</select>
                                    <?php } ?>                            			
									
                                    <div class="form-group">
										<label>User</label> <?php $user_data = ( ($log->created_by == '0') ? 'System' : $Dashboard_user->getElement($log->created_by) );//BoUser::GetOneUser($db, $log->created_by) ); ?>
                                        <input type="text" class="form-control" placeholder="description" id="description" name="description" value="<?php echo ( (isset($user_data) && ($user_data != 'System') ) ? '<a href="user_edit.php?id='.$user_data->id.'">'.$user_data->username.'</a>' : $user_data ); ?>" disabled="disabled" onchange="ChangeForm();">
                                    </div>
                                    
                                    	
								</div>
                                      
                            </div><!-- /.box -->
							
							
                        </div>
                        
										
<!-- END PAGE -->
<?php include_once('footer.php')?>