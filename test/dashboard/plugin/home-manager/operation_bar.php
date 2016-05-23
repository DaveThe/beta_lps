<?php
namespace Dashboard;
    
    if(isset($_GET["id_delete"]) && trim($_GET["id_delete"])!="" && is_numeric($_GET["id_delete"]) && $DELETE ) {
    	if(HomeBlock::Delete($db, $_GET["id_delete"])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=440');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=445');
    		exit ();
    	}
    }
    if(isset($_GET["id_approve"]) && trim($_GET["id_approve"])!="" && is_numeric($_GET["id_approve"]) && $PUBLISH) {
    	if(HomeBlock::Approve($db, $_GET["id_approve"])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=420');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=425');
    		exit ();
    		}
    }
    if(isset($_GET["id_disapprove"]) && trim($_GET["id_disapprove"])!="" && is_numeric($_GET["id_disapprove"]) && $PUBLISH) {
    	if(HomeBlock::Disapprove($db, $_GET["id_disapprove"])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=430');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=435');
    		exit ();
    	}
    }
        
?>