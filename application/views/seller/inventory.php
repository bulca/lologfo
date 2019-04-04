<div class="page-header">
	<h1><?=$type->name?><small>Unsold Accounts</small></h1>
</div>
<div class="row">
	<div class="col-md-3">
		<select class="form-control" id="changeType">
			<?php foreach($types as $t): ?>
				<option value="<?=site_url('/seller/inventory/' . $t->type)?>" <?=$type->type == $t->type ? 'selected="selected"' : ''?>><?=$t->name?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="col-md-9 text-right">
		<button id="delete" class="btn btn-danger btn-sm" disabled><i class="fa fa-trash-o"></i> Delete Selected</button>
	</div>
</div>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="powerwidget powerwidget-sortable" id="datatable-myaccounts" data-widget-editbutton="false">
			<header>
				<h2>Accounts<small><?=$type->name?></small></h2>
			</header>
		 	<div class="inner-spacer">
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
				<table id="accounts" class="table table-striped table-hover" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			            	<th align="right" width="10px"><input id="all" type="checkbox" class="checkall" /><label for="all"></label></th>
			            	<?php foreach($type->format as $key => $val): ?>
			                	<th><?=$val?></th>
			            	<?php endforeach; ?>
			            </tr>
			        </thead>
			 		<tbody>
			 			<?php if(count($data) == 0): ?>
			 				<tr>
			 					<td align="right" colspan="<?=count((array)$type->format) + 1?>" class="text-center"><b>No results found</b></td>
			 				</tr>
			 			<?php else: ?>
			 				<?php foreach($data as $dval):
			 					$d = json_decode($dval->meta);
			 					?>
			 				<tr class="tooltiped" title="Last Updated: <?=$dval->updated_at == 0 ? 'Unknown' : date('l, F j, Y', $dval->updated_at)?>">
			 					<td align="center"><input id="<?=$dval->id?>" style="display:block" type="checkbox" /></td>
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
				<div class="row">
					<div class="col-xs-6">
						<div class="dataTables_info">Showing <?=$page['start'] + 1?> to <?=$page['start'] + count($data)?> of <?=$total?> entries</div>
					</div>
					<div class="col-xs-6">
						<div class="dataTables_paginate paging_bootstrap">
							<ul class="pagination">
								<?php $_GET['page'] = $page['back']; ?>
								<li class="prev <?=$page['back'] == $page['current'] ? 'disabled': ''?>"><a href="<?=site_url('/seller/inventory/' . $type->type . '?' . http_build_query($_GET))?>">← Previous</a></li>
								<?php if($page['back'] != $page['current']): ?>
									<?php $_GET['page'] = $page['back']; ?>
									<li><a href="<?=site_url('/seller/inventory/' . $type->type . '?' . http_build_query($_GET))?>"><?=$page['back']?></a></li>
								<?php endif; ?>
								<?php $_GET['page'] = $page['current']; ?>
								<li class="active"><a href="<?=site_url('/seller/inventory/' . $type->type . '?' . http_build_query($_GET))?>"><?=$page['current']?></a></li>
								<?php if($page['next'] != $page['current']): ?>
									<?php $_GET['page'] = $page['next']; ?>
									<li><a href="<?=site_url('/seller/inventory/' . $type->type . '?' . http_build_query($_GET))?>"><?=$page['next']?></a></li>
								<?php endif;
									$_GET['page'] = $page['next'];
									?>
								<li class="next <?=$page['next'] == $page['current'] ? 'disabled': ''?>"><a href="<?=site_url('/seller/inventory/' . $type->type . '?' . http_build_query($_GET))?>">Next → </a></li>
							</ul>
						</div>
					</div>
				</div>
		 	</div>
		</div>
	</div>
</div>