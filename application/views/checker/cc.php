<div class="page-header">
	<h1>Checker<small>Credit Card Checker</small></h1>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="alert alert-danger hide">
			<strong></strong>
		</div>
	</div>
</div>
<div class="row" id="powerwidgets">
	<div class="col-md-9 bootstrap-grid"> 
		<div class="powerwidget cold-grey" id="cc-checker" data-widget-editbutton="false" data-widget-deletebutton="false">
			<header>
				<h2>Credit Card Checker<small>Insert List</small></h2>
			</header>
			<div class="inner-spacer">
				<div class="alert alert-success animated fadeIn" style="display:none">
    				<strong>Finished!</strong> <span></span>
    				<div class="pull-right">
   		 				<a download="" href="#">download as txt</a>
  					</div>
  				</div>
				<div class="row">
					<div class="col-md-12">
						<textarea autofocus class="form-control goaway" rows="15" name="list"></textarea>
						<div style="max-height: 340px;overflow-y: scroll;">
							<table class="table" style="display:none">
								<thead>
									<tr>
										<th></th>
									<?php foreach($type->checker->format as $key):
	   									$val = $type->format->{$key};
	   								?>
	   								<th><?=$val?></th>
	   								<?php endforeach; ?>
	   								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="pull-right">
							<br>
							<button id="startChecker" class="btn btn-primary goaway">Check</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3 bootstrap-grid"> 
		<div class="powerwidget dark-cold-grey" id="checker-format" data-widget-editbutton="false" data-widget-deletebutton="false">
			<header>
				<h2>Format<small>List Format</small></h2>
			</header>
			<div class="inner-spacer">
				<table class="table table-striped table-hover margin-0px">
            		<thead>
                    	<tr>
                      		<th width="70%">Name</th>
                      		<th>Index</th>
						</tr>
                  	</thead>
                  	<tbody>
   						<tr>
   							<td><label for="delim">Delimeter:</label></td>
   							<td>
   								<input type="text" name="delim" class="form-control text-center" value="|">
   							</td>
   						</tr>
   					<?php
   						$idx = 0;
   						foreach($type->checker->format as $key):
   							$val = $type->format->{$key};
   							?>
   						<tr>
   							<td><label for="<?=$key?>"><?=$val?>:</label></td>
   							<td>
   								<input type="text" name="<?=$key?>" class="form-control text-center" value="<?=$idx++?>">
   							</td>
   						</tr>
   					<?php endforeach; ?>
					</tbody>
                </table>
			</div>
		</div>
	</div>
</div>