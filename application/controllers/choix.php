<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class choix extends  MY_Controller {
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->output->set_title('Choix');
		$this->load->view('simplexe/choix');
	}
}