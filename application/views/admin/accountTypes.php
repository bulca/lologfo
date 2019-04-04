<div class="page-header">
	<h1>Admin<small>Edit account types</small></h1>
</div>
<div>
	<?php 
		$i = 0;
		foreach($types as $type): ?>
		<?php if($i == 0): ?>
			
		<?php endif; ?>

		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<div class="shop-item animated bounceInDown">
				<a href="<?=site_url('/admin/editAccountType/' . $type->type)?>">
					<img src="images/type/<?=$type->type?>.png" />
					<?=$type->name?>
				</a>
			</div>
		</div>

		<?php
			if($i == 2) {
				//echo '</div';
				$i = 0;
			} else {
				$i++;
			}
		?>

	<?php endforeach; ?>
</div>