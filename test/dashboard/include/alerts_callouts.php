<div class="box-body">
	<?php if(sizeof($errors)>0) 
	{ 
		foreach($errors as $elem)
		{
	?>		
		<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<b>Alert!</b> <?php echo($elem); ?>
		</div>
	<?php } 
	
	} 
	
	if(isset($respok) && $respok !== "") {
	
	?>
	
	<div class="alert alert-success alert-dismissable">
		<i class="fa fa-check"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Alert!</b> <?php echo($respok); ?>.
	</div>
	<?php } ?>
	
	<?php if(isset($element) && sizeof($element) == 0) { ?>
	
		<div class="alert alert-info alert-dismissable">
			<i class="fa fa-info"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<b>Alert!</b> No record found for the filter applied.
		</div>
		
	<?php } ?>
	<!--
	<div class="alert alert-warning alert-dismissable">
		<i class="fa fa-warning"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Alert!</b> Warning alert preview. This alert is dismissable.
	</div> -->
	
    
</div>