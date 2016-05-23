
<!-- general form elements disabled -->
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">Search Elements</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<form method="get" <?php echo ((isset($_GET["plug"]) || isset($_GET["p_page"]) ) ? ' action="plugs.php?'.$querystring.'"' : '') ?> >
        <?php echo ((isset($_page) ) ? ' <input type="hidden" name="p_page" value="'.$_page.'" />' : '') ?>
        <?php echo ((isset($_plug) ) ? ' <input type="hidden" name="plug" value="'.$_plug.'" />' : '') ?>
			<!-- text input -->
			<div class="form-group">
				<label>Text</label>
				<input type="text" class="form-control" name="text" maxlength="50" value="<?php echo $_text;?>" placeholder="Enter ..."/>
			</div>

			<!-- radio -->
			<div class="form-group">
				<div class="radio">
					<label>
						<input type="radio" name="st" id="optionsRadios1" value="0" <?php echo(!isset($_st) || ( isset($_st) && $_st == 0 ) ? 'checked="checked"' : '' ); ?> >
						Tutti gli elementi
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="st" id="optionsRadios2"  value="1" <?php echo(isset($_st) && $_st == 1 ? 'checked="checked"' : ''); ?> >
						Solo elementi validi
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="st" id="optionsRadios2" value="2" <?php echo(isset($_st) && $_st == 2 ? 'checked="checked"' : ''); ?> >
						Solo elementi da approvare
					</label>
				</div>
				
				<div class="box-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>

		</form>
	</div><!-- /.box-body -->
</div><!-- /.box -->