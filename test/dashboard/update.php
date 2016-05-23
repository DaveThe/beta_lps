<?php
include_once(dirname(__FILE__).'/config/include.php');
include_once(Class_PATH.'Class_update.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo (NOME_PRJ); ?> | <?php echo($area['title']); ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <?php include_once(THEME.'/include/lib_js.php'); ?>	
        <script type="text/javascript">
            
            $( document ).ready(function() {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                
                document.getElementById("progressupdate").ClassName = 'progress horizontal progress-striped active';
                
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        //alert( xmlhttp.responseText );
                        if(xmlhttp.responseText == true )
                        document.getElementById("updatecount").innerHTML = '1';
                        
                        document.getElementById("progressupdate").ClassName = 'progress horizontal progress-striped';
                    }
                }
                xmlhttp.open("GET","../include/updater.php?current=<?php echo $settings->db_version ?>",true);
                xmlhttp.send();
            });
        </script>
    </head>

    <body class="sidebar-mini skin-<?php echo ( $Dashboard_user->GetSkin() ); ?>-light ">

		<?php include_once('header.php'); ?>
		
        <div Class="wrapper row-offcanvas row-offcanvas-left">
		<?php include_once('menu_left.php'); ?>
		<?php include_once('page_bar.php'); ?>

				<?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('alerts_callouts.php'); ?>
				    
                    
                    <div Class="row">
                        
                        <div Class="col-md-4">
                            <h4>Controllo versione in corso</h4>
                        </div>
                        <div Class="col-md-8">
                            <div id="progressupdate" Class="progress horizontal progress-striped active">
                                <div Class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                    <span Class="sr-only">20%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                        <div Class="box box-solid">
                            <div Class="box-header">
                                <i Class="fa fa-text-width"></i>
                                <h3 Class="box-title">ChangeLog | Versione Sistema: (<?php echo ($settings->dashboard_version); ?>) - Versione Database: (<?php echo ($settings->db_version); ?>)</h3>
                            </div><!-- /.box-header -->
                            <div Class="box-body">
                                <ul>
                                    <li>Introdotto gestione temi (l'abilita ancora non va)</li>
                                    <li>Settato colore progetto anche dai setting</li>
                                    <li>Bugfix vari.</li>
                                </ul>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                        
                        <div Class="box box-solid">
                            <div Class="box-header">
                                <i Class="fa fa-text-width"></i>
                                <h3 Class="box-title">ChangeLog | Versione Sistema: (0.1) - Versione Database: (0.1)</h3>
                            </div><!-- /.box-header -->
                            <div Class="box-body">
                                <ul>
                                    <li>Spostato colonna "prj_color" dalla tabella dei settings alla tabella degli utenti</li>
                                    <li>Aggiunto le colonne per la versione del database e del sistema.</li>
                                    <li>Rifatta la grafica del dettaglio utente</li>
                                    <li>Sistemata la gestione dell'avatar utente.</li>
                                    <li>Modificati componenti pagina dei settings.</li>
                                    <li>Creata pagina di aggiornamento (non funzionante).</li>
                                </ul>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                        
                    
				</section><!-- /.content -->
			</aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
	    <?php include_once('enable_plugin_js.php'); ?>

    </body>
</html>
<?php include_once('footer.php')?>