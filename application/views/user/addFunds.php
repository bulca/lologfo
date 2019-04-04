<div class="page-header">

	<h1>Add Funds<small>Load money into your account</small></h1>

</div>

<?php
if(true):
	if(isset($send_to)):
			$value_in_btc = file_get_contents("https://litepay.ch/api/tobtc?currency=USD&value=" . $price);
		?>	
		<div class="col-md-4"></div>
		<div class="col-md-4">
		<div class="powerwidget cold-grey powerwidget-sortable" data-widget-deletebutton="false" data-widget-editbutton="false" role="widget" style="">
			<div class="inner-spacer" role="content">
				<div class="row">
					<div class="col-md-12"> 
	 <h2>Bitcoin Purchase</h2>
						<p>Please send a payment of <b><?=$value_in_btc?></b> to the address below (transactions can take up to 10 minutest):</p>
						<pre><?=$send_to?></pre>
						<center><small>Any bitcoin sent to that temporary address will be automatically funded into your account even if it doesn't match the price.</small></center> 
					</div>
				</div>
			</div> 
		</div>
	</div>
		<?php
	else:
?>

		<?php if(isset($success)): ?>

			<div class="alert alert-success">
				<strong>Sweet!</strong> Your have successfully completed your order of <?=$success?>. Funds should show up in your account in a couple minutes if not instantly.

			</div>

		<?php endif; ?>

		<div class="powerwidget cold-grey powerwidget-sortable" data-widget-deletebutton="false" data-widget-editbutton="false" role="widget" style="">

			<div class="inner-spacer" role="content">

				<div class="row">

					<div class="col-md-12">
                     	
					<div class="center-block" style="position:static; width: 200px">
						 	<form method="POST" class="orb-form">
			           <section>
					   <label class="input"> <i class="icon-prepend fa fa-credit-card"></i>
			                        	<input autocomplete="off" type="text" placeholder="5.00" value="5.00" name="price">
									</label>
			                    </section>								
			                    <div class="alert alert-danger"><b>Minimum amount: 5$</b></div><br>
					   <div class="alert alert-danger"><b>Payments smaller than 0.001 BTC will be considered as donation.</b></div><br>
			                   <section>
			                    	<input type="image" src="images/buynow.png"/>
			                    </section> 
							</form>
						

						</div>
			    <div style="margin-left:20%;margin-right:20%;" class="callout callout-danger">
                  		<h4>Remember...</h4>
				- Funds to appear on your account may take anywhere between <b>1 minute</b> and <b>2 hours</b>.<br>
				- Before writing a ticket to support, wait atleast <b>45 minutes</b>.<br>
				- Don't forget to <b>write your deposit address</b>, it will speed up the process of supporting you with your payment.
                  	</div>

					</div>

				</div>

			</div>

		</div>
	<?php endif;?>
<?php else: ?>
	<div class="alert alert-danger">

		<strong>Sorry!</strong> Adding funds is being updated and will return later. Sorry for the inconvenience.

	</div>
<?php endif; ?>
