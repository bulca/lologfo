<?php if(isset($type->search)): ?>
<form method="GET">
<div class="powerwidget powerwidget-sortable" id="datatable-accountssearch" data-widget-editbutton="false">
	<header>
		<h2>Search<small>Redefine results</small></h2>
	</header>
 	<div class="inner-spacer">
 		<?php $i = 0; foreach($type->search as $k => $v): $i++; ?>
 			<?php if($i == 1) echo '<div class="row">'; ?>

	 		<div class="col-md-2">
	 			<label for="<?=$k?>"><?=$v->name?>:</label>
	 		</div>
	 		<div class="col-md-4">
	 			<?php if($v->type == 'select'): ?>
	 				<select name="<?=$k?>">
	 					<?php foreach($v->options as $v): ?>
	 						<option value="<?=$v?>" <?=isset($_GET[$k]) && $_GET[$k] == $v ? 'selected' : ''?>><?=$v?></option>
	 					<?php endforeach; ?>
	 				</select>
	 			<?php else: ?>
	 				<input type="text" name="<?=$k?>" value="<?=isset($_GET[$k]) ? $_GET[$k] : ''?>"/>
	 			<?php endif; ?>
	 		</div>

	 		<?php 
	 		if($i == 2) {
	 			echo '</div><br>';
	 			$i = 0;
	 		}
	 		?>
 		<?php endforeach; ?>
 		<?php if($i != 0) echo '</div>'; ?>
 		<div class="col-md-12 text-right">
 			<input type="submit" value="Redefine" />
 		</div>
 	</div>
</div>
</form>
<?php endif; ?>
<div class="powerwidget powerwidget-sortable" id="datatable-accounts" data-widget-editbutton="false">
	<header>
		<h2>Accounts<small><?=$type->name?></small></h2>
	</header>
 	<div class="inner-spacer">
 		<?php if($type->type == 'cc'): ?>
		 	<div class="callout callout-warning">
				<h4>We've got you covered</h4>
				<p>Before every CC purchase, our system checks to see if it is alive or not. If the CC happens to be dead, your funds will be refunded.</p>
			</div>
		<?php endif; ?>
		<?php if(isset($purchased)): ?>
			<div class="alert alert-success">
				<strong>Great!</strong> Your purchase has been successful.
			</div>
		<?php endif; ?>
		<?php if(isset($error)): ?>
			<div class="alert alert-danger">
				<strong>Aww Snap.</strong> <?=$error?>
			</div>
		<?php endif; ?>
		<div style="white-space:pre;overflow:auto;width:100%;">
		<table style="width:1080px" id="accounts" class="table table-striped table-hover" cellspacing="0">
	        <thead>
	            <tr>
	            	<th width="1%"></th>
	            	<?php foreach($type->format as $key => $val): ?>
	                	<th width="5%"><?=$val?></th>
	            	<?php endforeach; ?>
	            </tr>
	        </thead>
	 		<tbody>
	 			<?php if(count($data) == 0): ?>
	 				<tr>
	 					<td colspan="<?=count((array)$type->format) + 1?>" class="text-left"><b>No results found</b></td>
	 				</tr>
	 			<?php else: ?>
	 				<?php foreach($data as $dval):
	 					$d = json_decode($dval->meta);
	 					?>
	 				<tr class="tooltiped" title="Last Updated: <?=$dval->updated_at == 0 ? 'Unknown' : date('l, F j, Y', $dval->updated_at)?>">
	 					<td><?=anchor('/buy?account=' . $dval->id . '&type=' . $dval->type, '<i class="fa fa-shopping-cart"></i> $' . $dval->price)?></td>
	 					<?php foreach($type->format as $key => $val): ?>
	 						<?php if(isset($d->{$key})): ?>
	 							<td><?=$d->{$key}?></td>
	 						<?php else: ?>
	 							<td><b>N/A</b></td>
	 						<?php endif; ?>
	 					<?php endforeach; ?>
	 					
	 				</tr>
	 				<?php endforeach; ?>
	 			<?php endif; ?>
	 		</tbody>
	        <tfoot>
	            <tr>
	            	<th></th>
	            	<?php foreach($type->format as $key => $val): ?>
	                	<th><?=$val?></th>
	            	<?php endforeach; ?>
	            </tr>
	        </tfoot>
	    </table>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<div class="dataTables_info">Showing <?=$page['start'] + 1?> to <?=$page['start'] + count($data)?> of <?=$total?> entries</div>
			</div>
			<div class="col-xs-6">
				<div class="dataTables_paginate paging_bootstrap">
					<ul class="pagination">
						<?php $_GET['page'] = $page['back']; ?>
						<li class="prev <?=$page['back'] == $page['current'] ? 'disabled': ''?>"><a href="<?=site_url('/shop/' . $type->type . '?' . http_build_query($_GET))?>">← Previous</a></li>
						<?php if($page['back'] != $page['current']): ?>
							<?php $_GET['page'] = $page['back']; ?>
							<li><a href="<?=site_url('/shop/' . $type->type . '?' . http_build_query($_GET))?>"><?=$page['back']?></a></li>
						<?php endif; ?>
						<?php $_GET['page'] = $page['current']; ?>
						<li class="active"><a href="<?=site_url('/shop/' . $type->type . '?' . http_build_query($_GET))?>"><?=$page['current']?></a></li>
						<?php if($page['next'] != $page['current']): ?>
							<?php $_GET['page'] = $page['next']; ?>
							<li><a href="<?=site_url('/shop/' . $type->type . '?' . http_build_query($_GET))?>"><?=$page['next']?></a></li>
						<?php endif;
							$_GET['page'] = $page['next'];
							?>
						<li class="next <?=$page['next'] == $page['current'] ? 'disabled': ''?>"><a href="<?=site_url('/shop/' . $type->type . '?' . http_build_query($_GET))?>">Next → </a></li>
					</ul>
				</div>
			</div>
		</div>
 	</div>
</div>