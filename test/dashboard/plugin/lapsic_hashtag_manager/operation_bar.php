<?php
namespace Dashboard;
    
    if(isset($_GET["id_delete"]) && trim($_GET["id_delete"])!="" && is_numeric($_GET["id_delete"]) && $DELETE ) {
    	if(LapsicHashTag::Delete($db, $_GET["id_delete"])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=440');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=445');
    		exit ();
    	}
    }
    if(isset($_GET["id_approve"]) && trim($_GET["id_approve"])!="" && is_numeric($_GET["id_approve"]) && $PUBLISH) {
    	if(LapsicHashTag::Approve($db, $_GET["id_approve"])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=420');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=425');
    		exit ();
    		}
    }
    if(isset($_GET["id_disapprove"]) && trim($_GET["id_disapprove"])!="" && is_numeric($_GET["id_disapprove"]) && $PUBLISH) {
    	if(LapsicHashTag::Disapprove($db, $_GET["id_disapprove"])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=430');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=435');
    		exit ();
    	}
    }
    
    if(isset($_GET["id_delete_data"]) && trim($_GET["id_delete_data"])!="" && is_numeric($_GET["id_delete_data"]) && $DELETE ) {
    	if(LapsicHashTagGroup::Delete($db, $_GET["id_delete_data"])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=440');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=445');
    		exit ();
    	}
    }
    if(isset($_GET["id_approve_data"]) && trim($_GET["id_approve_data"])!="" && is_numeric($_GET["id_approve_data"]) && $PUBLISH) {
    	if(LapsicHashTagGroup::Approve($db, $_GET["id_approve_data"])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=420');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=425');
    		exit ();
    		}
    }
    if(isset($_GET["id_disapprove_data"]) && trim($_GET["id_disapprove_data"])!="" && is_numeric($_GET["id_disapprove_data"]) && $PUBLISH) {
    	if(LapsicHashTagGroup::Disapprove($db, $_GET["id_disapprove_data"])) {
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=430');
    		exit ();
    	}else{
    		header('Location: '.$_SERVER['PHP_SELF'].'?pag'.$_pag.'&'.$querystring.'&resp_code=435');
    		exit ();
    	}
    }
    
?>
<script>

function deleteData(id){
	if(confirm('Sei sicuro di voler eliminare l\'elemento selezionato?')) {
		location.href='<?php echo $_SERVER['PHP_SELF']; ?>?pag=<?php echo $_pag.'&'.$querystring ?>&id_delete_data='+id;
	}
}

function approvaData(id){
	if(confirm('Sei sicuro di voler approvare l\'elemento selezionato?')) {
		location.href='<?php echo $_SERVER['PHP_SELF']; ?>?pag=<?php echo $_pag.'&'.$querystring ?>&id_approve_data='+id;
	}
}
function disapprovaData(id){
	if(confirm('Sei sicuro di voler togliere l\'approvazione all\'elemento?')) {
		location.href='<?php echo $_SERVER['PHP_SELF']; ?>?pag=<?php echo $_pag.'&'.$querystring ?>&id_disapprove_data='+id;
	}
}

</script>