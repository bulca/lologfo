 	<div class="colorful-page-wrapper">
		<div class="center-block">
    		<div class="login-block register-block">
      			<form id="form-register" method="POST" action="" class="orb-form" novalidate="novalidate">
          			<?php if(!isset($success)): ?>
	        			<fieldset>
	        			<br><center>Have an account? — <?=anchor('/login', 'Login')?></center><br>
	        					<?php if(isset($error)): ?>
		        					<section>
		        						<div class="row">
		        							<div class="col col-12">
												<div class="alert alert-danger alert-dismissable">
		                  							<strong>Uh Oh!</strong> <?=$error?>
		        							</div>
		        					</section>
	        					<?php endif; ?>
								<section>
						    		<div class="row">
						        		<label class="label col col-4">Username</label>
						              	<div class="col col-8">
						                	<label class="input"> <i class="icon-append fa fa-user"></i>
						                  		<input autocomplete="off" type="text" name="username" maxlength="15" value="<?=set_value('username')?>">
						                	</label>
						              	</div>
						            </div>
								</section>
		          				<section>
						   			<div class="row">
						     			<label class="label col col-4">Password</label>
						              	<div class="col col-8">
						                	<label class="input"> <i class="icon-append fa fa-lock"></i>
						                  		<input maxlength="32" id="password" type="password" name="password">
						                	</label>
						              	</div>
						            </div>
								</section>
		          				<section>
						   			<div class="row">
						     			<label class="label col col-4"></label>
						              	<div class="col col-8">
						                	<label class="input"> <i class="icon-append fa fa-lock"></i>
						                  		<input maxlength="32" id="confirm_password" type="password" name="confirm_password">
												<b class="tooltip tooltip-top-right">Re-enter the password you entered above</b>
						                	</label>
						              	</div>
						            </div>
								</section>
		          				<section>
						   			<div class="row">
						     			<label class="label col col-4">Jabber ID:</label>
						              	<div class="col col-8">
						                	<label class="input"> <i class="icon-append fa fa-envelope"></i>
						                  		<input maxlength="40" autocomplete="off" type="email" name="email" value="<?=set_value('email')?>">
						                	</label>
						              	</div>
						            </div>
								</section>
	        			</fieldset>

	        			<footer>
	          				<button type="submit" class="btn btn-primary">Login</button>
	        			</footer>
	        		<?php else: ?>
	        			<meta http-equiv="refresh" content="5;url=<?=site_url('/login')?>">
	        			<fieldset>
		        			<section>
		        				<div class="row">
		        					<div class="col col-12">
										<div class="alert alert-danger">
		                  					<strong>Awesome!</strong> Your account has been successfully created, you will be redirected in the login page in 5 seconds. If nothing happens, you can press the login button below.
		        					</div>
		        			</section>
	        			</fieldset>
	        			<footer>
	        				<?=anchor('/login', 'Login', 'class="btn btn-danger"')?>
	        			</footer>
	        		<?php endif; ?>
      			</form>
   			</div>
		</div>
