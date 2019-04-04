 <div class="page-header">
	<h1>Account Types<small>Editing <i><?=$type->type?></i></small></h1>
</div>
<form method="POST">
	<div class="row">
		<div class="col-md-12">
			<div class="big-icons-buttons clearfix margin-bottom">
				<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i>Save Changes</button>
				<a href="<?=site_url('/admin/editAccountType/' . $type->type)?>" class="btn btn-sm btn-danger <?=isset($error) ? '' : 'disabled'?>"><i class="fa fa-save"></i>Revert Changes</a>
			</div>
		</div>
	</div>
	<?php if(isset($error)): ?>
		<div class="alert alert-danger">
			<strong>Error:</strong> <?=$error?>
		</div>
	<?php elseif(isset($success)): ?>
		<div class="alert alert-success">
			<strong>Awesome!</strong> Your changes has been saved.
		</div>
	<?php endif; ?>
	<div class="row" id="powerwidgets">
		<div class="col-md-12 bootstrap-grid sortable-grid ui-sortable"> 
			<div class="powerwidget dark-cold-grey powerwidget-sortable" id="newsandupdatestl" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false">
				<header>
	                <h2>Format</h2>
					<span class="powerwidget-loader"></span>
				</header>
				<div role="content">
					<textarea name="format" id="format" rows="4" style="width: 100%;height:350px"><?=isset($_POST['format']) ? $_POST['format'] : json_encode($type->format, JSON_PRETTY_PRINT)?></textarea>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="js/vendors/ace/ace.js"></script>
<script src="js/vendors/ace/theme-twilight.js"></script>
<script src="js/vendors/ace/mode-json.js"></script>
<script src="js/vendors/ace/jquery-ace.min.js"></script>
<script>
	$('#format').ace({ theme: 'twilight', lang: 'json' });
	function resizeAce() {
  		return $('.ace_editor').css('width', '100%');
	}
	$(window).on('resize', function () {
    	resizeAce();
    	console.log('resize');
	});
</script>