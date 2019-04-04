<?php

	$menu = $this->config->item('menu');

	$useMenu = isset($useMenu) ? $useMenu : 'default';

	$activeMenu = $menu[$useMenu];

	$activeMenuItem = isset($laf['menu']) ? $laf['menu'] : '';

?>



<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" class=" js csstransforms3d">

<head>

	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $site_name . (isset($title) ? " | $title" : "") ?></title>    

    <base href="<?=base_url()?>">

    <link href="css/vendors/alertify/alertify.core.css" rel="stylesheet" type="text/css" />

    <link href="css/vendors/alertify/alertify.bootstrap.css" rel="stylesheet" type="text/css" />

    <link href="css/styles.css" rel="stylesheet" type="text/css">

    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

    <script type="text/javascript" src="js/vendors/modernizr/modernizr.custom.js"></script>

    <style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>

    <script type="text/javascript" src="js/vendors/jquery/jquery.min.js"></script> 

</head>



<body>

	<div class="smooth-overflow">

		<nav class="main-header clearfix" role="navigation">

			<a class="navbar-brand" href="index.html"><span class="text-blue">Spam.BZ</span></a> 

   

   

    		<div class="navbar-content">

				<h4><?=$this->usermodel->get_bal()?>$</h4>

    		</div>

		</nav>



		<div class="main-wrap">

			<aside class="user-menu"> 

        		<div class="tabs-offcanvas">

          			<ul class="nav nav-tabs nav-justified">

            			<li class="active"><a href="#userbar-me" data-toggle="tab"></a></li>

          			</ul>

	          		<div class="tab-content"> 

	            		<div class="tab-pane active" id="userbar-me">

		              		<div class="main-info">

		                		<h1><?=$this->usermodel->get_name()?> <small><?=$this->usermodel->get_title()?></small></h1>

		             	 	</div>

		              		<div class="list-group">

		              			<?php if($this->usermodel->has_any_perm_in('admin')): ?>

		              				<?=anchor('/admin', '<i class="fa fa-cogs"></i>Admin Panel', 'class="list-group-item"')?>

		                		<?php endif; ?>

		              			<?php if($this->usermodel->has_any_perm_in('ticketm')): ?>

		              				<?=anchor('/ticket-manager', '<i class="fa fa-comments"></i>Ticket Manager', 'class="list-group-item"')?>

		                			<div class="empthy"></div>

		                		<?php endif; ?>

		                		<?=anchor('/settings', '<i class="fa fa-cog"></i> Settings', 'class="list-group-item goaway"')?>

		                		<?=anchor('/logout', '<i class="fa fa-power-off"></i> Sign Out', 'class="list-group-item goaway"')?>

		                	</div>

	            		</div>

	          		</div>

       			 </div>

			</aside>

			<div class="responsive-admin-menu">

        		<div class="responsive-menu"><?=$site_name?>

          			<div class="menuicon"><i class="fa fa-angle-down"></i></div>

        		</div>

	        	<ul id="menu">

	        		<?php foreach($activeMenu as $key => $m):

	        			if(isset($m['perm'])) {

	        				if(!$this->usermodel->has_any_perm_in($m['perm']))

	        					continue;

	        			}



	        			if(isset($m['func']))

	        				$m['func']($this, $m);

	        			?>

	          			<li><?=anchor($m['href'], '<i class="' . $m['icon'] . '"></i><span> ' . $m['title'] . (isset($m['badge']) ? ' <span class="badge">' . $m['badge'] . '</span>' : '') . '</span>', 'title="' . $m['title'] . '" class="' . ($activeMenuItem == $key ? 'active' : '') . (isset($m['children']) ? ' submenu" data-id="' . $key : '') . '"')?>

	       	 			

		       	 			<?php if(isset($m['children'])): ?>

		       	 			<ul id="<?=$key?>" class="accordion">

		       	 				<?php foreach($m['children'] as $child): ?>

		       	 				<li><a href="<?=$child['href']?>"><?=$child['title']?></a></li>

		       	 				<?php endforeach; ?>

		       	 			</ul>

		       	 			<?php endif; ?>

		       	 		</li>

	       	 		<?php endforeach; ?>

	       	 	</ul>

      		</div>

      		<div class="content-wrapper">


	      		<?php echo $this->template->jisgay(); ?>

      		</div>

		</div>

	</div>



	<script type="text/javascript" src="js/vendors/jquery/jquery-ui.min.js"></script> 

	<script type="text/javascript" src="js/vendors/forms/jquery.form.min.js"></script> 

	<script type="text/javascript" src="js/vendors/forms/jquery.validate.min.js"></script> 

	<script type="text/javascript" src="js/vendors/forms/jquery.maskedinput.min.js"></script> 

	<script type="text/javascript" src="js/vendors/jquery-steps/jquery.steps.min.js"></script> 

	<script type="text/javascript" src="js/vendors/alertify/alertify.min.js"></script> 

	<script type="text/javascript" src="js/vendors/fullscreen/screenfull.min.js"></script>

	<script type="text/javascript" src="js/vendors/nanoscroller/jquery.nanoscroller.min.js"></script> 

	<script type="text/javascript" src="js/vendors/sparkline/jquery.sparkline.min.js"></script>

	<script type="text/javascript" src="js/vendors/powerwidgets/powerwidgets.min.js"></script>

	<script type="text/javascript" src="js/vendors/summernote/summernote.min.js"></script>

	<script type="text/javascript" src="js/vendors/bootstrap/bootstrap.min.js"></script>

	<script type="text/javascript" src="js/scripts.js?v=11"></script>



	<!--/Scripts-->



	<?php // echo $this->template->message(); ?>

    

    <?php // echo $this->template->yield(); ?>

    

</body>

</html>

