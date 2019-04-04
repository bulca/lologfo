<div class="page-header">
	<h1>Ticket #<?=$ticket->id?><small><?=$ticket->topic?> | ID: <?=$ticket->order?></small></h1>
</div>
<div class="row" id="powerwidgets">
	<div class="col-md-12 bootstrap-grid">
		<div class="powerwidget cold-grey" id="chat" data-widget-editbutton="false">
			<header>
				<h2>Chat</h2>
			</header>
			<div class="inner-spacer">
				<div class="chat-container">
      				<div class="top-buttons clearfix">
                    	<h2 class="margin-0px pull-left">Chat</h2>
                    	<span class="badge"><?=1 + count($messages)?></span>
                    	<div class="btn-group btn-group-sm pull-right">
                    		<?php if($ticket->open == 1): ?>
                    			<a href="<?=site_url(($tm ? '/ticket-manager/' : '/support/') . $ticket->id . '?toggle=true')?>" class="btn btn-danger"><i class="fa fa-folder"></i> Close Ticket</a>
                    		<?php else: ?>
                    			<a href="<?=site_url(($tm ? '/ticket-manager/' : '/support/') . $ticket->id . '?toggle=true')?>" class="btn btn-danger"><i class="fa fa-folder-open"></i> Open Ticket</a>
                    		<?php endif; ?>
                    	</div>
                  	</div>

                  	<div class="chat-container">
                    	<div class="chat-pusher">
                      		<div class="chat-content"><!-- this is the wrapper for the content -->
                        		<div class="nano"><!-- this is the nanoscroller -->
                          			<div class="nano-content">
                            			<div class="chat-content-inner"><!-- extra div for emulating position:fixed of the menu --> 
                              				<div class="clearfix">
                                				<div class="chat-messages chat-messages-with-sidebar">
                                  					<ul>
                                    					<li class="left clearfix">
                                     	 					<div class="chat-body clearfix">
                                        						<div class="header"> <span class="name"><?=$tm ? $ticket->username : 'You'?></span><span class="name"></span> <span class="badge"><i class="fa fa-clock-o"></i><?=ago($ticket->date)?></span></div>
                                        						<p><?=$this->typography->nl2br_except_pre($ticket->content)?></p>
                                      						</div>
                                    					</li>
                                    					<?php foreach($messages as $m): ?>
	                                    					<li class="<?= $m->user == $this->usermodel->get_id() ? 'left' : 'right'?> clearfix">
	                                     	 					<div class="chat-body clearfix">
	                                        						<div class="header"> <span class="name"><?= $m->user == $this->usermodel->get_id() ? 'You' : $m->username?></span><span class="name"></span> <span class="badge"><i class="fa fa-clock-o"></i><?=ago($m->date)?></span></div>
	                                        						<p><?=$this->typography->nl2br_except_pre($m->message)?></p>
	                                      						</div>
	                                    					</li>
                                    					<?php endforeach; ?>
                                  					</ul>
                               					</div>
                              				</div>
                            			</div>
                          			</div>
                        		</div>
                 		 	</div>
                    	</div>
                  	</div>
                </div>
                <div class="chat-message-form">
                	<form method="POST" id="form-ticketmessage">
	              		<div class="row">
                        <?php if($ticket->open == 0): ?>
                        <div class="col-md-12">
                          <div class="alert alert-warning">
                            <strong>Heads up!</strong> Replying to this closed ticket will open it back up.
                          </div>
                        </div>
                        <?php endif; ?>
	                    	<div class="col-md-12">
	                      		<textarea maxlength="512" name="message" placeholder="Write Your Message Here" class="form-control margin-bottom" rows="4"></textarea>
	                    	</div>
	                    	<div class="col-md-8 col-sm-8 col-xs-8">
	                    	</div>
	                    	<div class="col-md-4 col-sm-4 col-xs-4">
	                      		<button class="btn btn-info pull-right" type="submit"">Send</button>
	                    	</div>
	                  	</div>
	               	</form>
                </div>
      		</div>
      	</div>
    </div>
</div>
