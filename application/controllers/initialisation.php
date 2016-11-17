<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class initialisation extends  MY_Controller {
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->output->set_title('Initialisation');
		
		$data['nb_variable']=$this->input->post('nb_variable');
		$data['nb_equation']=$this->input->post('nb_equation');
		$data['type']=$this->input->post('type');
		$this->load->view('simplexe/initialisation',$data);
	}
}