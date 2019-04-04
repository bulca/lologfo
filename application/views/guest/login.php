	<div class="colorful-page-wrapper">
		<div class="center-block">
    		<div class="login-block">
      			<form id="form-login" class="orb-form" method="POST" novalidate="novalidate">
        			<fieldset>
        			<br><center>Have no account? — <?=anchor('/register', 'Register')?></center><br>
	        				<?php if(isset($error)): ?>
		        				<section>
		        					<div class="row">
		        						<div class="col col-12">
											<div class="alert alert-danger alert-dismissable">
		                  						<strong>Sorry.</strong> <?=$error?>
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
					                  		<input type="password" maxlength="32" name="password">
					                	</label>
					                	<!--<div class="note"><a href="#">Forgot password?</a></div>-->
					              	</div>
					            </div>
							</section>
        			</fieldset>
        			<footer>
          				<button type="submit" class="btn btn-default">Log in</button>
        			</footer>
      			</form>
      			
   			</div>
		</div>
