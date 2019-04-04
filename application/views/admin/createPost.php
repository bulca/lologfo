<div class="page-header">
	<h1>News Feed<small>Create New Post</small></h1>
</div>
<div class="inbox-new-message">
	<form method="POST" id="form-createpost" role="form">
		<div class="row">
			<div class="form-group col-md-6">
				<input autocomplete="off" type="text" name="title" class="form-control" placeholder="Post Title" maxlength="128" value="<?=set_value('title')?>">
			</div>
			<div class="form-group col-md-2">
				<select class="form-control" name="color">
					<option value="pink" <?=set_select('color', 'pink', TRUE);?>>Pink</option>
					<option value="blue" <?=set_select('color', 'blue', TRUE);?>>Blue</option>
					<option value="green" <?=set_select('color', 'green', TRUE);?>>Green</option>
					<option value="acid-green" <?=set_select('color', 'acid-green', TRUE);?>>Acid Green</option>
					<option value="yellow" <?=set_select('color', 'yellow', TRUE);?>>Yellow</option>
					<option value="yellow-muted" <?=set_select('color', 'yellow-muted', TRUE);?>>Yellow Muted</option>
					<option value="purple" <?=set_select('color', 'purple', TRUE);?>>Purple</option>
					<option value="grey" <?=set_select('color', 'grey', TRUE);?>>Grey</option>
					<option value="cold-grey" <?=set_select('color', 'cold-grey', TRUE);?>>Cold Grey</option>
					<option value="dark-cold-grey" <?=set_select('color', 'dark-cold-grey', TRUE);?>>Dark Cold Grey</option>
					<option value="orange" <?=set_select('color', 'orange', TRUE);?>>Orange</option>
					<option value="red" <?=set_select('color', 'red', TRUE);?>>Red</option>
					<option value="black" <?=set_select('color', 'black', TRUE);?>>Black</option>
					<option value="marine" <?=set_select('color', 'marine', TRUE);?>>Marine</option>
				</select>
			</div>
			<div class="form-group col-md-2">
				<input type="text" name="icon" class="form-control" value="<?=set_value('icon')?>" placeholder="Fontawesome Icon (eg: wrench)" maxlength="15">
			</div>
			<div class="form-group col-md-2 text-right hidden-xs hidden-sm">
				<button type="submit" class="btn btn-default">Save</button>
			</div>
		</div>
      	<textarea id="summernote" data-height="400" name="content"><?=set_value('content')?></textarea>
		<div class="text-right hidden-lg hidden-md">
			<button type="submit" class="btn btn-default">Save</button>
		</div>
	</form>
</div>