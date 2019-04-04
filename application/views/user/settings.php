<div class="page-header">
	<h1>Account Settings<small>Modify your account</small></h1>
</div>
<div class="row" id="powerwidgets">
	<div class="col-md-4"></div>
	<div class="col-md-4 bootstrap-grid"> 
		<div class="powerwidget cold-grey" id="settings" data-widget-deletebutton="false" data-widget-editbutton="false">
			<header>
				<h2>Settings<small>Account Details</small></h2>
			</header>
			<div class="inner-spacer">
				<?php if(isset($error)): ?>
					<div class="alert alert-danger">
						<strong><?=$error?></strong>
					</div>
				<?php elseif(isset($success)): ?>
					<div class="alert alert-success">
						<strong>Your account has been successfully updated</strong>
					</div>
				<?php endif; ?>
				<h3><i class="fa fa-lock"></i> Change Password</h3>
				<form method="POST" class="orb-form" id="form-usersettings">
					<fieldset>
                    	<section>
                      		<label class="input"> <i class="icon-prepend fa fa-key"></i>
                        	<input name="newpassword" type="password" placeholder="New Password">
                    	</section>
                    	<section>
                      		<label class="input"> <i class="icon-prepend fa fa-key"></i>
                        	<input name="newpassword2" type="password" placeholder="Confirm New Password">
                        	<b class="tooltip tooltip-top-left">Re-enter the same password above</b> </label>
                    	</section>
                    	<br />
                    	<section>
                      		<label class="input"> <i class="icon-prepend fa fa-lock"></i>
                        	<input name="password" type="password" placeholder="Current Password">
                    	</section>
					</fieldset>
					<footer>
                    	<button type="submit" class="btn btn-default">Submit</button>
                  	</footer>
				</form>
			</div>
		</div>
	</div>
</div>