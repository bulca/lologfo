<div class="page-header">
	<h1>Seller Settings<small>Modify your account</small></h1>
</div>
<div class="row" id="powerwidgets">
	<div class="col-md-4"></div>
	<div class="col-md-4 bootstrap-grid"> 
		<div class="powerwidget cold-grey" id="settings" data-widget-editbutton="false" data-widget-deletebutton="false">
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
				<h3><i class="fa fa-money"></i> BTC Address</h3>
				<form method="POST" class="orb-form" id="form-usersettings">
					<fieldset>
                    	<section>
                      		<label class="input"> <i class="icon-prepend fa fa-money"></i>
                        	<input name="btca" type="text" placeholder="BTC Address" autocomplete="off" value="<?=$this->usermodel->btc_address()?>">
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