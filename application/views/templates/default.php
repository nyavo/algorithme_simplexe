<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="resource-type" content="document" />
<meta name="robots" content="all, index, follow" />
<meta name="googlebot" content="all, index, follow" />
<?php $this->load->view('templates/head'); ?>
</head>
<body>
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
	
</body>
</html>
