<div class="page-header">
	<h1>Ticket Manager<small></small></h1>
</div>
<div class="row" id="powerwidgets">
	<div class="col-md-12 bootstrap-grid"> 
		<div class="powerwidget cold-grey" id="ticketmanager" data-widget-editbutton="false">
			<header>
				<h2>Ticket Manager<small>All Tickets</small></h2>
			</header>
			<div class="inner-spacer">
				<div class="mailinbox">
					<div class="row">
						<div class="col-md-1">
							<div class="left-content">
	                        	<div class="list-group">
	                        		<a id="opened" href="#" class="list-group-item active"><i class="entypo-inbox"></i><b>Opened</b><span class="badge"><?=$open?></span></a>
	                        		<a id="closed" href="#" class="list-group-item"><i class="entypo-doc-text"></i><b>Closed</b><span class="badge"><?=$closed?></span></a>
	                        	</div>
	                      </div>
	                    </div>
	                    <div class="col-md-11">
							<div class="right-content clearfix">
								<div class="big-icons-buttons clearfix margin-bottom">
	                          		<div class="btn-group btn-group-sm pull-right">
	                          			<a class="btn btn-default delete"><i class="fa fa-times-circle"></i> Delete</a>
	                          			<a id="refresh" class="btn btn-default refresh"><i class="fa fa-refresh"></i> Refresh</a>
	                          			<a id="refund" class="btn btn-default refund"><i class="fa fa-stop"></i> Refund</a>
	                          		</div>
	                        	</div>
	                        	<div class="table-relative table-responsive">
	                          		<table id="tickets" class="table table-condensed table-striped margin-0px">
	                            		<thead>
	                              			<tr>
	                                			<th><input id="all" type="checkbox" class="checkall" /><label for="all"></label></th>
	                                			<th>Message Header</th>
	                               	 			<th>Date</th>
	                              			</tr>
	                            		</thead>
	                            		<tbody>
	                            			<?php foreach($data as $d): ?>
                              				<tr class="<?=$d->unread2 == 0 ? '' : 'unread'?>">
                                				<td align="center"><input id="<?=$d->id?>" style="display:block" type="checkbox" /></td>
                                				<td><a href="<?=$d->link?>"><?=$d->topic?><small><?=$d->short_content?></small></a></td>
                                				<td><?=$d->date_text?> <small><a href="<?=$d->link?>"><?=$d->ago?> <i class="fa fa-caret-right"></i></a></small></td>
                              				</tr>
                              				<?php endforeach; ?>
	                           			</tbody>
	                           			<tbody>
                              				<tr>
                              					<td colspan="3" align="center" style="height:100px">
                              						<?php if(count($data) == 0): ?>
                              						Nothing to display
                              						<?php endif; ?>
                              					</td>
                              				</tr>
	                           			</tbody>
	                          		</table>
	                        	</div>
	                        	<div id="pagination" class="margin-top">
	                        		<div class="padding-15px pull-left"><small>Showing: <span><?=$page['start'] + 1?> to <?=$page['start'] + count($data)?> of <?=$total?> entries</span></small></div>
	                        		<ul class="pagination pagination-sm pull-right margin-0px">
										<li class="prev <?=$page['back'] == $page['current'] ? 'disabled': ''?>"><a href="#">← Previous</a></li>
										<li class="active"><a href=""><?=$page['current']?></a></li>
										<li class="next <?=$page['next'] == $page['current'] ? 'disabled': ''?>"><a href="#">Next → </a></li>
									</ul>
								</div>
							</div>
	                    </div>
					</div>
	  			</div>
				<div class="inbox-new-message">
					<!--<div class="callout callout-danger">
                  		<h4>Attention</h4>
                  		Any of abuse of the support system or the support staff can result in the termination of your account.
                  	</div>-->
	    			<div class="page-header">
						<h3>New Ticket<small>Compose New</small></h3>
					</div>
					<form method="POST" id="openTicket" role="form">
						<div class="row">
	                      	<div class="form-group col-md-12">
	                        	<input autocomplete="off" maxlength="30" name="topic" type="text" class="form-control" placeholder="Topic of Ticket">
	                        	<input autocomplete="off" maxlength="10" name="order" type="text" class="form-control" placeholder="Order ID">
	                      	</div>
	                    </div>
	                    <textarea maxlength="512" autocomplete="off" class="form-control" rows="10" name="content" placeholder="Message"></textarea>
	                    <br />
	                    <button type="submit" class="btn btn-info">Send</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
