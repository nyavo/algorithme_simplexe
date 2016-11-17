<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<title><?php echo $title; ?></title>
<?php $base_url = base_url(); ?>
<script type="text/javascript">
root = "<?php echo $base_url; ?>";
</script>
<!-- The styles -->
<link id="bs-css"
	href="<?php echo $base_url; ?>static/css/bootstrap-cerulean.css"
	rel="stylesheet">
<style type="text/css">
body {
	padding-bottom: 40px;
}

.sidebar-nav {
	padding: 9px 0;
}
</style>
<!-- <link href="<?php echo $base_url; ?>static/css/bootstrap-responsive.css" rel="stylesheet"> -->
<link href="<?php echo $base_url; ?>static/css/charisma-app.css"
	rel="stylesheet">
<!-- <link href="<?php echo $base_url; ?>static/css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
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
<link href='<?php echo $base_url; ?>static/css/uploadify.css' rel='stylesheet'> -->
<link href='<?php echo $base_url; ?>static/css/perso.css'
	rel='stylesheet'>


<!-- <script src="<?php echo $base_url;?>static/js/jquery-1.7.2.min.js"></script>
<!-- jQuery UI -->
<!-- <script
	src="<?php echo $base_url;?>static/js/jquery-ui-1.8.21.custom.min.js"></script>-->
</head>

<body>
<?php $this->load->view('templates/header')?>
	<div id="content_wrapper_">
		<!-- LES CHAMPS HIDDEN COMMUNS UTILISES -->

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
		<hr>
			<footer class="row-fluid center">
				
					&copy; <a href="https://www.facebook.com/rina.leromain" target="_blank">ANDRIANANTENAINA Ny Avo Rina Rakotoson</a> : 
					M1Pro ENI 2015
					
				
			</footer>
		<div class="clearfix"></div>
		<?php //$this->load->view('partials/footer');?>
		<!-- MESSAGE INFO -->
		<div style="display: none;" class="err-msg alert alert-danger"
			role="alert">
			<span></span>
		</div>
		<div style="display: none;" class="bb-alert alert alert-info">
			<span></span>
		</div>

	</div>

</body>
</html>
