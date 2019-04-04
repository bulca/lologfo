<div class="page-header">
	<h1>Shop<small>What are you looking for?</small></h1>
</div>
<div>
	<?php 
	#header('Location: ./shop');
	if(count($types) == 0): ?>
	<center><b>The vendor you supplied currently has nothing to sell or doesn't exist.</b><br><?=anchor('/shop', 'View All')?></center>
	<meta http-equiv="refresh" content="0; url=./shop" />
	<?php else: ?>
		<?php 
			$i = 0;
			foreach($types as $type): ?>
			<?php if($i == 0): ?>
				
			<?php endif; ?>

			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				<div class="shop-item animated bounceInDown">
					<a href="<?=site_url('/shop/' . $type->type . (isset($vendor) ? '?vendor=' . $vendor : '') )?>">
						<img src="images/type/<?=$type->type?>.png" />
						<?php
							echo $type->name;
							$this->db->select('*');
							$this->db->from('account');
							$this->db->where('buyer', '0');
							$this->db->where('type', $type->type);
							echo " <strong>(".$this->db->count_all_results().")</strong>";
						?>
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
	<?php endif; ?>
</div>
