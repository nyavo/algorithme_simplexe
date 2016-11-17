<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_init();
	}

	private function _init()
	{
		$this->output->set_template('templates/default');

		// Chargement des fichiers CSS
		/*$this->load->css('assets/css/bootstrap.min.css');
		$this->load->css('assets/css/bootstrap-responsive.min.css');
		$this->load->css('assets/css/style.css');
		$this->load->css('assets/css/style-responsive.css');
		$this->load->css('http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext');
		$this->load->css('assets/css/bootstrap-table.css');
		$this->load->css('assets/css/concours.css');*/

		// Chargement des fichiers JS

		/*$this->load->js('assets/js/jquery-1.9.1.min.js');
		$this->load->js('assets/js/jquery-1.9.1.min.js');
		$this->load->js('assets/js/jquery-migrate-1.0.0.min.js');

		$this->load->js('assets/js/jquery-ui-1.10.0.custom.min.js');

		$this->load->js('assets/js/jquery.ui.touch-punch.js');
		

		$this->load->js('assets/js/modernizr.js');

		$this->load->js('assets/js/bootstrap.min.js');

		$this->load->js('assets/js/jquery.cookie.js');

		$this->load->js('assets/js/fullcalendar.min.js');

		$this->load->js('assets/js/jquery.dataTables.min.js');

		$this->load->js('assets/js/excanvas.js');
		$this->load->js('assets/js/jquery.flot.js');
		$this->load->js('assets/js/jquery.flot.pie.js');
		$this->load->js('assets/js/jquery.flot.stack.js');
		$this->load->js('assets/js/jquery.flot.resize.min.js');

		$this->load->js('assets/js/jquery.chosen.min.js');

		$this->load->js('assets/js/jquery.uniform.min.js');

		$this->load->js('assets/js/jquery.cleditor.min.js');

		$this->load->js('assets/js/jquery.noty.js');

		$this->load->js('assets/js/jquery.elfinder.min.js');

		$this->load->js('assets/js/jquery.raty.min.js');

		$this->load->js('assets/js/jquery.iphone.toggle.js');

		$this->load->js('assets/js/jquery.uploadify-3.1.min.js');

		$this->load->js('assets/js/jquery.gritter.min.js');

		$this->load->js('assets/js/jquery.imagesloaded.js');

		$this->load->js('assets/js/jquery.masonry.min.js');

		$this->load->js('assets/js/jquery.knob.modified.js');

		$this->load->js('assets/js/jquery.sparkline.min.js');
		$this->load->js('assets/js/locales/bootstrap-table.fr.js');

		$this->load->js('assets/js/counter.js');

		$this->load->js('assets/js/retina.js');

		$this->load->js('assets/js/custom.js');
		$this->load->js('assets/js/bootstrap-table.js');
		$this->load->js('assets/js/concours.js');*/
	}
}