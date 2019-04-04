<div class="row" id="powerwidgets">
	<div class="col-md-12 bootstrap-grid sortable-grid ui-sortable"> 
		<div class="powerwidget blue powerwidget-sortable" id="newsandupdatestl" data-widget-deletebutton="false" data-widget-editbutton="false">
			<header>
                <h2>News &amp; Updates<small>Timeline</small></h2>
				<span class="powerwidget-loader"></span>
			</header>
			<div class="inner-spacer" role="content">
				<div class="activity-block">
					<ul class="tmtimeline">
						<?php foreach($feed as $f):
							
							?>
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
				</div>
			</div>
		</div>
	</div>
</div>