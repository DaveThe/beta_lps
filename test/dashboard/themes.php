<?php
include_once(dirname(__FILE__).'/config/include.php');
include_once('class_themes.php');

$themes = Themes::GetAllThemes();

if(isset($_POST["act"]) && $_POST["act"] == 'save') 
{
	if(isset($_POST['prj_color']) && trim($_POST['prj_color']) != '') 
    {
		$Dashboard_user->prj_color		    = $_POST['prj_color'];
	}
    else
    {
		$errors[] 							= "Devi inserire il colore del sito";
	}
			
	if(sizeof($errors) == 0) 
    {	
        $ret                = false;
        $res                = $Dashboard_user->UpdateSkin();
        
        if($res) 
        {
			$resp_code 		= 110;
			$ret			= Log::Insert($db, 2, 2, $_SESSION['dashboard_iduser'], $id, 'Modifica dettagli '.$area['title']);
		} 
        else
        {
			$resp_code 		= 115;	
		}
                            			
		if($ret) 
        {
			header('Location: '.$area_sub->pagina.'.php?id=' . $settings->id . '&resp_code=' . $resp_code);
			exit ();
		} 
        else 
        {
			$resp_code 		= 635;
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
        
		<?php include_once(THEME.'/include/lib_js.php'); ?>
		
	</head>


    <body class="sidebar-mini skin-<?php echo ( $Dashboard_user->GetSkin() ); ?>-light ">

		<?php include_once('header.php'); ?>
		
        <div Class="wrapper row-offcanvas row-offcanvas-left">
		<?php include_once('menu_left.php'); ?>
				<?php include_once('page_bar.php'); ?>
				
				<?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('alerts_callouts.php'); ?>
				
                
                    <?php for($i = 0; $i < count($themes); $i++){ ?>
                    
                        <div Class="col-md-4">
                            <div Class="box box-solid bg-light-grey" style="padding: 10px;">
                                
                                <div Class="box box-solid" style="min-height: 200px;">
                                    <div Class="box-header">
                                        <h3 Class="box-title">Carousel</h3>
                                    </div><!-- /.box-header -->
                                    <div Class="box-body">
                                        <div id="carousel-<?php echo ( $themes[$i]['name'] ); ?>" Class="carousel slide" data-ride="carousel">
                                            <div Class="carousel-inner">
                                                <?php for($k = 0; $k < count($themes[$i]['carousel']); $k++){ ?>
                                                <div Class="item <?php echo( ($k == 0)?'active':'' ); ?>">
                                                    <img src="<?php echo ( $themes[$i]['carousel'][$k] ) ?>">                                        
                                                </div>
                                                <?php } ?>
                                            </div>
                                            
                                            <a Class="left carousel-control" href="#carousel-<?php echo ( $themes[$i]['name'] ); ?>" data-slide="prev">
                                                <span Class="glyphicon glyphicon-chevron-left"></span>
                                            </a>
                                            <a Class="right carousel-control" href="#carousel-<?php echo ( $themes[$i]['name'] ); ?>" data-slide="next">
                                                <span Class="glyphicon glyphicon-chevron-right"></span>
                                            </a>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                                
                                        
                                <div Class="box box-solid">
                                    <div Class="box-header">
                                        <i Class="fa fa-text-width"></i>
                                        <h3 Class="box-title">Description</h3>
                                    </div><!-- /.box-header -->
                                    <div Class="box-body">
                                        <dl Class="dl-horizontal">                                
                                            <dt>Name</dt>
                                            <dd><?php echo ( $themes[$i]['name'] ) ?></dd>
                                            <dt>Author</dt>
                                            <dd><?php echo ( $themes[$i]['author'] ) ?></dd>
                                            <dt>Description</dt>
                                            <dd><?php echo ( $themes[$i]['description'] ) ?></dd>
                                        </dl>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                                <div Class="box box-solid">
                                    <form role="form" method="post">
											<input type="hidden" name="act" value="save" />
                                        <?php if($themes[$i]['status'] === 'active'){ ?>
                                            <button Class="btn bg-olive btn-flat margin disabled">Attivo</button>
                                        <?php } else { ?>                                        
                                            <button Class="btn btn-flat margin">Non attivo</button>
                                        <?php } ?>
                                        
										<!-- select -->
										<div Class="form-group">
											<label>Skin sito</label>
											<select Class="form-control" <?php echo ( ($themes[$i]['status'] === 'active')?'':'disabled' ); ?> id="prj_color" name="prj_color">
												<option value="blue" <?php echo ( ( isset($Dashboard_user->prj_color) && $Dashboard_user->prj_color == 'blue' ) ? 'selected="selected"': '' ); ?> >Blue</option>
												<option value="black" <?php echo ( ( isset($Dashboard_user->prj_color) && $Dashboard_user->prj_color == 'black' ) ? 'selected="selected"': '' ); ?>>Black</option>
											</select>
										</div>
                                        	
                                    </form>
                                </div>
                            </div>
                        </div>
                        
					<?php } ?>    
                                    
				</section><!-- /.content -->
			</aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
	    <?php include_once('enable_plugin_js.php'); ?>
    </body>
</html>
<?php include_once('footer.php')?>