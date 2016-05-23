<?php
namespace Dashboard;
    $class = ucwords ( strtolower( (PAGE_NAME != 'PLUGS') ? PAGE_NAME : 'NEWS' ) ); 
    if (PAGE_NAME == 'USER') $class = $Dashboard_user;
    if(PAGE_SUB != '') $class =  str_replace('_list','',str_replace('_edit','',ucwords (strtolower (PAGE_SUB))));
    //echo '-'.$class.'-';
    $declared = get_declared_classes();
    if( in_array('Dashboard\\'.$class,$declared) ){ $class = 'Dashboard\\'.$class; }
    //print_r(get_declared_classes());
    //var_dump(in_array('Dashboard\\'.$class,$declared));
    //echo '-'.$class.'-';
    
    if(strpos($class, 'Dashboard') === false){ $class = 'Dashboard\\'.$class; }
    //if(!class_exists($class)){ echo 'non esiste la classe cercata';}
    //echo '-'.$class.'-';
    
    /* print_r(get_include_path());
    if(!class_exists($class)) 
        trigger_error("Unable to load class: $class", E_USER_WARNING);
    */
    if(isset($_GET["id_delete"]) && trim($_GET["id_delete"])!="" && is_numeric($_GET["id_delete"]) && $DELETE ) {
    	if($class::Delete($db, $_GET["id_delete"])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=440');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=445');
    		exit ();
    	}
    }
    if(isset($_GET["id_approve"]) && trim($_GET["id_approve"])!="" && is_numeric($_GET["id_approve"]) && $PUBLISH) {
    	if($class::Approve($db, $_GET["id_approve"])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=420');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=425');
    		exit ();
    		}
    }
    if(isset($_GET["id_disapprove"]) && trim($_GET["id_disapprove"])!="" && is_numeric($_GET["id_disapprove"]) && $PUBLISH) {
    	if($class::Disapprove($db, $_GET["id_disapprove"])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=430');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=435');
    		exit ();
    	}
    }
    if(isset($_GET["id_OtherStatus"]) && trim($_GET["id_OtherStatus"])!="" && is_numeric($_GET["id_OtherStatus"]) && $PUBLISH) {
    	if($class::OtherStatus($db, $_GET["id_OtherStatus"], $_GET['status'])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=430');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=435');
    		exit ();
    	}
    }
    if(isset($_GET["installSection"]) && trim($_GET["installSection"])!="" && is_numeric($_GET["installSection"]) && $WRITE) {
    	if($plugins->Install($_GET["installSection"])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=430');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=435');
    		exit ();
    	}
    }
    
?>