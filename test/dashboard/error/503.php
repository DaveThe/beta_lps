<?php
$errors         = array();
$resp_code      = isset($_GET["resp_code"]) && is_numeric($_GET["resp_code"]) ? (int) ($_GET["resp_code"]) : 0;
$respok         = NULL;

include_once(dirname(dirname(dirname(dirname(__FILE__)))).'/config/config.php');
include_once('foo_error.php');

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8859-1">
        <title><?php echo(NOME_PRJ); ?> | 503 Error</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		
		<?php include_once(THEME.'/include/lib_js.php'); ?>	
    </head>
	
    <body Class="skin-blue">
        
        <div Class="wrapper row-offcanvas row-offcanvas-left">

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside Class="right-side strech">
                <!-- Content Header (Page header) -->
                <section Class="content-header" style="text-align: center;background-color: #3c8dbc;color: white;">
                    <h1>
                        500 Error Page
                    </h1>
                </section>

                <!-- Main content -->
                <section Class="content">
					<?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('../include/alerts_callouts.php'); ?>
                    <div Class="error-page">
                        <h2 Class="headline">503</h2>
                        <div Class="error-content">
                            <h3><i Class="fa fa-warning text-yellow"></i> Oops! Something went wrong.</h3>
                            <p>
                                We will work on fixing that right away.
                                Meanwhile, you may <a href="../index.php">return to dashboard</a> or try using the search form.
                            </p>
                            <form Class='search-form'>
                                <div Class='input-group'>
                                    <input type="text" name="search" Class='form-control' placeholder="Search"/>
                                    <div Class="input-group-btn">
                                        <button type="submit" name="submit" Class="btn btn-info"><i Class="fa fa-search"></i></button>
                                    </div>
                                </div><!-- /.input-group -->
                            </form>
                        </div>
                    </div><!-- /.error-page -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
    </body>
</html>
