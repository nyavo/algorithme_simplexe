<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<title><?php echo $title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
	content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
<meta name="author" content="Muhammad Usman">
<?php $base_url = base_url(); ?>
<script type="text/javascript">
root = "<?php echo $base_url; ?>";
</script>
<!-- The styles -->
<link id="bs-css" href="<?php echo $base_url; ?>static/css/bootstrap-cerulean.css" rel="stylesheet">
<style type="text/css">
body {
	padding-bottom: 40px;
}

.sidebar-nav {
	padding: 9px 0;
}
</style>
<link href="<?php echo $base_url; ?>static/css/bootstrap-responsive.css" rel="stylesheet">
<link href="<?php echo $base_url; ?>static/css/charisma-app.css" rel="stylesheet">
<link href="<?php echo $base_url; ?>static/css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
<link href='<?php echo $base_url; ?>static/css/fullcalendar.css' rel='stylesheet'>
<link href='<?php echo $base_url; ?>static/css/fullcalendar.print.css' rel='stylesheet' media='print'>
<link href='<?php echo $base_url; ?>static/css/chosen.css' rel='stylesheet'>
<link href='<?php echo $base_url; ?>static/css/uniform.default.css' rel='stylesheet'>
<link href='<?php echo $base_url; ?>static/css/colorbox.css' rel='stylesheet'>
<link href='<?php echo $base_url; ?>static/css/jquery.cleditor.css' rel='stylesheet'>
<link href='<?php echo $base_url; ?>static/css/jquery.noty.css' rel='stylesheet'>
<link href='<?php echo $base_url; ?>static/css/noty_theme_default.css' rel='stylesheet'>
<link href='<?php echo $base_url; ?>static/css/elfinder.min.css' rel='stylesheet'>
<link href='<?php echo $base_url; ?>static/css/elfinder.theme.css' rel='stylesheet'>
<link href='<?php echo $base_url; ?>static/css/jquery.iphone.toggle.css' rel='stylesheet'>
<link href='<?php echo $base_url; ?>static/css/opa-icons.css' rel='stylesheet'>
<link href='<?php echo $base_url; ?>static/css/uploadify.css' rel='stylesheet'>
<link href='<?php echo $base_url; ?>static/css/perso.css' rel='stylesheet'>

<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

<!-- The fav icon -->
<link rel="shortcut icon" href="img/favicon.ico">

</head>

<body>
	<?php $this->load->view('templates/header')?>
	<div id="content_wrapper_">
		<!-- LES CHAMPS HIDDEN COMMUNS UTILISES -->
		<div class="container">
			<div id="common_loader" style="display: none;">
				<img src="<?php echo img_url('ajax-loader-indicator.gif'); ?>" />
			</div>
		</div>
		
		<input type="hidden" id="base_url" value="<?php echo base_url();?>">
		<div class="container-fluid-full">
			<div class="row-fluid">
		<?php 
			//$this->load->view('partials/header');
			//$this->load->view('partials/sidebar');
			$this->load->view('templates/content');  
		?>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php //$this->load->view('partials/footer');?>
		<!-- MESSAGE INFO -->
		<div style="display: none;" class="err-msg alert alert-danger" role="alert">
		 <span></span>
		</div>
		<div style="display: none;" class="bb-alert alert alert-info">
		   <span></span>
		</div>	
	</div>
	
	
	
	
	
	<!-- external javascript
	================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- jQuery -->
<script src="<?php echo $base_url;?>static/js/jquery-1.7.2.min.js"></script>
<!-- jQuery UI -->
<script
	src="<?php echo $base_url;?>static/js/jquery-ui-1.8.21.custom.min.js"></script>
<!-- transition / effect library -->
<script src="<?php echo $base_url;?>static/js/bootstrap-transition.js"></script>
<!-- alert enhancer library -->
<script src="<?php echo $base_url;?>static/js/bootstrap-alert.js"></script>
<!-- modal / dialog library -->
<script src="<?php echo $base_url;?>static/js/bootstrap-modal.js"></script>
<!-- custom dropdown library -->
<script src="<?php echo $base_url;?>static/js/bootstrap-dropdown.js"></script>
<!-- scrolspy library -->
<script src="<?php echo $base_url;?>static/js/bootstrap-scrollspy.js"></script>
<!-- library for creating tabs -->
<script src="<?php echo $base_url;?>static/js/bootstrap-tab.js"></script>
<!-- library for advanced tooltip -->
<script src="<?php echo $base_url;?>static/js/bootstrap-tooltip.js"></script>
<!-- popover effect library -->
<script src="<?php echo $base_url;?>static/js/bootstrap-popover.js"></script>
<!-- button enhancer library -->
<script src="<?php echo $base_url;?>static/js/bootstrap-button.js"></script>
<!-- accordion library (optional, not used in demo) -->
<script src="<?php echo $base_url;?>static/js/bootstrap-collapse.js"></script>
<!-- carousel slideshow library (optional, not used in demo) -->
<script src="<?php echo $base_url;?>static/js/bootstrap-carousel.js"></script>
<!-- autocomplete library -->
<script src="<?php echo $base_url;?>static/js/bootstrap-typeahead.js"></script>
<!-- tour library -->
<script src="<?php echo $base_url;?>static/js/bootstrap-tour.js"></script>
<!-- library for cookie management -->
<script src="<?php echo $base_url;?>static/js/jquery.cookie.js"></script>
<!-- calander plugin -->
<script src='<?php echo $base_url;?>static/js/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='<?php echo $base_url;?>static/js/jquery.dataTables.min.js'></script>

<!-- chart libraries start -->
<script src="<?php echo $base_url;?>static/js/excanvas.js"></script>
<script src="<?php echo $base_url;?>static/js/jquery.flot.min.js"></script>
<script src="<?php echo $base_url;?>static/js/jquery.flot.pie.min.js"></script>
<script src="<?php echo $base_url;?>static/js/jquery.flot.stack.js"></script>
<script src="<?php echo $base_url;?>static/js/jquery.flot.resize.min.js"></script>
<!-- chart libraries end -->

<!-- select or dropdown enhancer -->
<script src="<?php echo $base_url;?>static/js/jquery.chosen.min.js"></script>
<!-- checkbox, radio, and file input styler -->
<script src="<?php echo $base_url;?>static/js/jquery.uniform.min.js"></script>
<!-- plugin for gallery image view -->
<script src="<?php echo $base_url;?>static/js/jquery.colorbox.min.js"></script>
<!-- rich text editor library -->
<script src="<?php echo $base_url;?>static/js/jquery.cleditor.min.js"></script>
<!-- notification plugin -->
<script src="<?php echo $base_url;?>static/js/jquery.noty.js"></script>
<!-- file manager library -->
<script src="<?php echo $base_url;?>static/js/jquery.elfinder.min.js"></script>
<!-- star rating plugin -->
<script src="<?php echo $base_url;?>static/js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="<?php echo $base_url;?>static/js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script
	src="<?php echo $base_url;?>static/js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script
	src="<?php echo $base_url;?>static/js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="<?php echo $base_url;?>static/js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="<?php echo $base_url;?>static/js/charisma.js"></script>

<script type="text/javascript">
//var root = "<?php echo $base_url;?>";
</script>
</body>
</html>
