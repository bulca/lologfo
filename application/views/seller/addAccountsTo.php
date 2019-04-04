<div class="page-header">
	<h1><?=$type->name?><small>Insert accounts</small></h1>
</div>
<form id="form-addaccount" method="POST">
<div class="row" id="powerwidgets">
	<div class="col-md-9 bootstrap-grid"> 
		<div class="row">
			<div class="col-md-12">
				<div class="big-icons-buttons clearfix margin-bottom">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i>Parse List</button>
					<button type="button" id="reset" class="btn btn-sm btn-danger"><i class="fa fa-refresh"></i>Reset</button>
				</div>
			</div>
		</div>
		<div class="powerwidget dark-cold-grey powerwidget-sortable" id="<?=$type->type?>" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false">
			<header>
				<h2>Accounts</h2>
				<span class="powerwidget-loader">Insert List</span>
			</header>
			<div class="inner-spacer" role="content">
				<textarea id="add-account-list" wrap="off" name="list" rows="15" placeholder="Paste list ..." class="form-control"><?=set_value('list')?></textarea>
			</div>
		</div>
	</div>
	<div class="col-md-3 bootstrap-grid"> 
		<div class="powerwidget dark-grey powerwidget-sortable" id="newsandupdatestl" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false">
			<header>
				<h2>Format</h2>
				<span class="powerwidget-loader"></span>
			</header>
			<div class="inner-spacer" role="content" style="padding:1px">
				<table class="table table-striped table-hover margin-0px">
            		<thead>
                    	<tr>
                      		<th width="70%">Name</th>
                      		<th>Index</th>
						</tr>
                  	</thead>
                  	<tbody>
   						<tr>
   							<td><label for="delim">Price:</label></td>
   							<td>
   								<input type="text" name="price" class="form-control text-center" value="2.50">
   							</td>
   						</tr>
   						<tr>
   							<td><label for="delim">Delimeter:</label></td>
   							<td>
   								<input type="text" name="delim" class="form-control text-center" value="|">
   							</td>
   						</tr>
   					<?php
   						$idx = 0;
   						foreach($type->format as $key => $val): ?>
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
</form>