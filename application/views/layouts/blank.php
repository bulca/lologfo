<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $site_name . (isset($title) ? " | $title" : "") ?></title>    
    <base href="<?=base_url()?>">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>
</head>

<body>
	<?php echo $this->template->jisgay(); ?>

	<!--Scripts--> 
	<!--JQuery--> 
	<script type="text/javascript" src="js/vendors/jquery/jquery.min.js"></script> 
	<script type="text/javascript" src="js/vendors/jquery/jquery-ui.min.js"></script> 

	<!--Forms--> 
	<script type="text/javascript" src="js/vendors/forms/jquery.form.min.js"></script> 
	<script type="text/javascript" src="js/vendors/forms/jquery.validate.min.js"></script> 
	<script type="text/javascript" src="js/vendors/forms/jquery.maskedinput.min.js"></script> 
	<script type="text/javascript" src="js/vendors/jquery-steps/jquery.steps.min.js"></script> 

	<!--NanoScroller--> 
	<script type="text/javascript" src="js/vendors/nanoscroller/jquery.nanoscroller.min.js"></script> 

	<!--Sparkline--> 
	<script type="text/javascript" src="js/vendors/sparkline/jquery.sparkline.min.js"></script> 

	<!--Main App--> 
	<script type="text/javascript" src="js/scripts.js"></script>

	<!--/Scripts-->

	<?php // echo $this->template->message(); ?>
    
    <?php // echo $this->template->yield(); ?>
    
</body>
</html>
