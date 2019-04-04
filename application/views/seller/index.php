<!--<div class="row">
	<div class="col-md-12">
		<div class="callout callout-info">
			<h5>Earns &amp; Taxes.</h5>
			<p>Thank you for becoming a seller! To celebrate our first ever sellers on Spam.BZ, your earnings will not be taxed until <b>August 1, 2014</b>.</p>
		</div>
	</div>
</div>-->
<?php if(!$this->usermodel->btc_address()): ?>
<div class="row">
	<div class="col-md-12">
		<div class="alert alert-danger">
			<strong>BTC Address Missing</strong> In order to be paid, you must supply your BTC address in the settings page.
		</div>
	</div>
</div>
<?php endif; ?>
<div class="row" id="powerwidgets">
	<div class="col-md-4 col-sm-12 bootstrap-grid"> 
		<div class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-cold-grey" id="widget2" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-editbutton="false">
			<header> </header>
			<div class="inner-spacer nopadding">
                <div class="portlet-big-icon animated bounceIn text-pink"><i class="fa fa-users"></i></div>
                <ul class="portlet-bottom-block">
                  	<li class="col-md-6 col-sm-6 col-xs-6"><strong><?=$this->usermodel->seller_total_accounts()?></strong><small>Total Accounts</small></li>
                  	<li class="col-md-6 col-sm-6 col-xs-6"><strong><?=$this->usermodel->seller_most_popular()?></strong><small>Best Seller</small></li>
				</ul>
			</div>
       	</div>
	</div>
	<div class="col-md-5 col-sm-12 bootstrap-grid"> 
		<div class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-green-alt" id="widget3" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-editbutton="false">
  			<header> </header>
			<div class="inner-spacer nopadding">
				<div class="portlet-big-icon"><i class="fa fa-money"></i></div>
     			<ul class="portlet-bottom-block">
            		<li class="col-md-3 col-sm-3 col-xs-3"><strong><?=$this->usermodel->seller_total_sales()?></strong><small>Total Sales</small></li>
            		<li class="col-md-3 col-sm-3 col-xs-3"><strong>$<?=$this->usermodel->seller_earned_today()?></strong><small>Today</small></li>
            		<li class="col-md-3 col-sm-3 col-xs-3"><strong>$<?=$this->usermodel->seller_earned_month()?></strong><small>Month</small></li>
            		<li class="col-md-3 col-sm-3 col-xs-3"><strong>$<?=$this->usermodel->balance_due()?></strong><small>Payout</small></li>
          		</ul>
        	</div>
		</div>  
	</div>
	<div class="col-md-3 col-sm-12 bootstrap-grid"> 
		<div class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-red" id="widget1" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-editbutton="false">
			<header> </header>
			<div class="inner-spacer nopadding">
                <div class="portlet-big-icon animated bounceIn"><i class="fa fa-globe"></i></div>
                <ul class="portlet-bottom-block">
                  	<li class="col-md-12 col-sm-12 col-xs-12"><strong>Shop URL</strong><small><?=anchor('/shop?vendor=' . $this->usermodel->get_id(), '', 'style="color:white"')?></small></li>
				</ul>
			</div>
       	</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="powerwidget dark-cold-grey powerwidget-sortable" id="shopact" data-widget-deletebutton="false" data-widget-editbutton="false">
			<header>
                <h2>Activity<small>Recent Shop Activity</small></h2>
				<span class="powerwidget-loader"></span>
			</header>
			<div class="inner-spacer" role="content">
				<div class="activity-block">
					<?php if(count($feed) == 0): ?>
						<p align="center"><b>Nothing has happened recently.</b></p>
					<?php else: ?>
					<ul class="tmtimeline">
					<?php foreach($feed as $f): ?>
							<li>
								<time class="tmtime" datetime="<?=date('c', $f->date)?>">
									<span><?=date('n/j/y', $f->date)?></span>
									<span><?=date('H:i', $f->date)?></span>
								</time>
	                      		<div class="tmicon bg-<?=$f->color . ' fa-' . $f->icon?>"></div>
	                      		<div class="tmlabel">
	                        		<h2><?=$f->header?></h2>
	                        		<p><?=$this->typography->nl2br_except_pre($f->content)?></p>
	                      		</div>
	                    	</li>
					<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
