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
		$this->load->view('simplexe/initialisation2',$data);
	}

	public function generalisation(){
		$this->output->set_title('Généralisation');

		$data['nb_variable'] = $nb_variable = $this->input->post('nb_variable');
		$data['nb_equation'] = $nb_equation = $this->input->post('nb_equation');
		$data['type']= $type = $this->input->post('type');

		$matrice = array();
		$coef_x = array();
		$nb_variable_artificielle = 0;
		$operation = array();
		for($i=0;$i<$nb_equation;$i++){
			$operation[$i] = $this->input->post('operation'.($i+1));
			for($j=0;$j<$nb_variable;$j++){
				$val = $this->input->post($i.$j) ? transformation($this->input->post($i.$j)) : transformation(0);
				$matrice[$i][$j] = $val;
				$coef_x[$j] = $this->input->post("coef_x".($j+1)) ? transformation($this->input->post("coef_x".($j+1))): transformation(0) ;
			}
			$b[$i]["numerique"] = $this->input->post("b_numerique".$i) ? transformation($this->input->post("b_numerique".$i)) : transformation(0) ;
			$b[$i]["litterale"] = $this->input->post("b_litterale".$i) ? transformation($this->input->post("b_litterale".$i)) : transformation(0) ;
				
			switch($operation[$i]){
				case "inf" :{
					$matrice[$i][$nb_variable + $i] = transformation(1);
					break;
				}
				case "sup" : {
					$matrice[$i][$nb_variable + $i] = transformation(-1);
					$matrice[$i][$nb_equation + $nb_variable + $nb_variable_artificielle] = transformation(1);
					$nb_variable_artificielle++;
					break;
				}
				case "egal":{
					
				}
			}
		}
		$data['nb_variable_artificielle'] = $nb_variable_artificielle;
		$data["operation"] = $operation;
		$data["matrice"] = $matrice;
		$data["b"] = $b;
		$data["coef_x"] = $coef_x;
		//var_dump($b);
		$this->load->view("simplexe/forme_generale",$data);
	}
}