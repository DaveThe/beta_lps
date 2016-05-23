<script type="text/javascript">
<!--
function deleteP(id){
	if(confirm('Sei sicuro di voler eliminare l\'elemento selezionato?')) {
		location.href='<?php echo $_SERVER['PHP_SELF']; ?>?pag=<?php echo $_pag.'&'.$querystring ?>&id_delete='+id;
	}
}
function approvaP(id){
	if(confirm('Sei sicuro di voler approvare l\'elemento selezionato?')) {
		location.href='<?php echo $_SERVER['PHP_SELF']; ?>?pag=<?php echo $_pag.'&'.$querystring ?>&id_approve='+id;
	}
}
function disapprovaP(id){
	if(confirm('Sei sicuro di voler togliere l\'approvazione all\'elemento?')) {
		location.href='<?php echo $_SERVER['PHP_SELF']; ?>?pag=<?php echo $_pag.'&'.$querystring ?>&id_disapprove='+id;
	}
}
function changeStatus(id, status){
	if(confirm('Sei sicuro di voler cambiare stato all\'elemento?')) {
		location.href='<?php echo $_SERVER['PHP_SELF']; ?>?pag=<?php echo $_pag.'&'.$querystring ?>&id_OtherStatus='+id+'&status='+status;
	}
}/*
function install(id){
	if(confirm('Sei sicuro di voler installare l\'elemento?')) {
		location.href='<?php echo $_SERVER['PHP_SELF']; ?>?pag=<?php echo $_pag.'&'.$querystring ?>&install='+id;
	}
}
function uninstall(id){
	if(confirm('Sei sicuro di voler disinstallare l\'elemento?')) {
		location.href='<?php echo $_SERVER['PHP_SELF']; ?>?pag=<?php echo $_pag.'&'.$querystring ?>&uninstall='+id;
	}
}*/
function installSection(id){
	if(confirm('Sei sicuro di voler installare la nuova sezione?')) {
		location.href='<?php echo $_SERVER['PHP_SELF']; ?>?pag=<?php echo $_pag.'&'.$querystring ?>&installSection='+id;
	}
}
//-->
</script>