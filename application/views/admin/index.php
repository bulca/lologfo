<div class="row" id="powerwidgets">
	<div class="col-md-6 col-sm-6 bootstrap-grid"> 
		<div class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-cold-grey" id="widget1" data-widget-editbutton="false">
			<header> </header>
			<div class="inner-spacer nopadding">
                <div class="portlet-big-icon animated bounceIn text-pink"><i class="fa fa-users"></i></div>
                <ul class="portlet-bottom-block">
                  	<li class="col-md-6 col-sm-6 col-xs-6"><strong>+<?=$this->usermodel->get_new_today()?></strong><small>New Today</small></li>
                  	<li class="col-md-6 col-sm-6 col-xs-6"><strong><?=$this->usermodel->total()?></strong><small>Total</small></li>
				</ul>
			</div>
       	</div>
	</div>
	<div class="col-md-6 col-sm-6 bootstrap-grid"> 
		<div class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-green-alt" id="widget3" data-widget-editbutton="false">
  			<header> </header>
			<div class="inner-spacer nopadding">
				<div class="portlet-big-icon"><i class="fa fa-money"></i></div>
     			<ul class="portlet-bottom-block">
            		<li class="col-md-4 col-sm-4 col-xs-4"><strong><?=$this->usermodel->get_sales_today()?></strong><small>Sales Today</small></li>
            		<li class="col-md-4 col-sm-4 col-xs-4"><strong>$<?=$this->usermodel->get_earned_today()?></strong><small>Earned Today</small></li>
            		<li class="col-md-4 col-sm-4 col-xs-4"><strong>$<?=$this->usermodel->get_total_earned()?></strong><small>Total Earned</small></li>
          		</ul>
        	</div>
		</div>  
	</div>
</div>