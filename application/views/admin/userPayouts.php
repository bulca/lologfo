<div class="page-header">
	<h1>$<?=$this->usermodel->admin_total_due()?> due<small>for <?=$this->usermodel->admin_need_payout()?> payout<?=$this->usermodel->admin_need_payout() == 1 ? '' : 's'?></small></h1>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="powerwidget dark-cold-grey powerwidget-sortable" id="userpayouts" data-widget-deletebutton="false" data-widget-editbutton="false">
			<header>
                <h2>Payouts<small>Sellers who need a payout</small></h2>
				<span class="powerwidget-loader"></span>
			</header>
			<div class="inner-spacer" role="content">
				<div class="activity-block">
					<?php if(count($users) == 0): ?>
						<p align="center"><b>Everyone has been paid.</b></p>
					<?php else: ?>
					<div id="items" class="items-switcher items-view-list">
                  		<ul>
                  			<?php foreach($users as $user): ?>
                    		<li>
                      			<div class="items-inner clearfix">
                      				<h3 class="items-title"><?=$user->username?></h3>
                      				<span class="label label-success">$<?=$this->usermodel->balance_due($user->id)?></span>
                      				<div class="items-details">
                      					<strong>BTC Address:</strong> <?=$user->btc_address? $user->btc_address : 'Not supplied'?>
                      				</div>
                      				<div class="control-buttons">
                      					<form method="post">
                      						<input name="user" value="<?=$user->id?>" type="hidden">
                      						<input name="due" value="<?=$user->balance_due?>" type="hidden">
                      						<input name="btca" value="<?=$user->btc_address?>" type="hidden">
                      						<button <?=$user->btc_address? '' : 'disabled'?> type="submit" title="Payment Sent" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                      					</form>
                      				</div>
                    			</div>
                			</li>
                    		<?php endforeach; ?>
                  		</ul>
                	</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>