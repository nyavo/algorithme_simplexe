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

		$nb_equation_suppl = 0;
		for($i=0;$i<$nb_equation;$i++){
			$operation[$i] = $this->input->post('operation'.($i+1));
			if($operation[$i] == "egal") $nb_equation_suppl++;
		}
		$id_eq = 0;
		for($i=0;$i<$nb_equation;$i++){
			$row = array();
			for($j=0;$j<$nb_variable;$j++){
				$val = $this->input->post($i.$j) ? transformation($this->input->post($i.$j)) : transformation(0);
				$row[$j] = $val;
				$coef_x[$j] = $this->input->post("coef_x".($j+1)) ? transformation($this->input->post("coef_x".($j+1))): transformation(0) ;
			}
			$b_tmp["numerique"] = $this->input->post("b_numerique".$i) ? transformation($this->input->post("b_numerique".$i)) : transformation(0) ;
			$b_tmp["litterale"] = $this->input->post("b_litterale".$i) ? transformation($this->input->post("b_litterale".$i)) : transformation(0) ;
			$row_negatif = negatif($row);
			if(!$row_negatif){
				switch($operation[$i]){
					case "inf" :{
						$op[] = "inf";
						$row[$nb_variable + $id_eq] = transformation(1);
						$id_eq++;
						$matrice[]=$row;
						$b[] = $b_tmp;
						break;
					}
					case "sup" : {
						$op[]="sup";
						$row[$nb_variable + $id_eq] = transformation(-1);
						$row[$nb_equation + $nb_equation_suppl + $nb_variable + $nb_variable_artificielle] = transformation(1);
						$nb_variable_artificielle++;
						$id_eq++;
						$matrice[]=$row;
						$b[] = $b_tmp;
						break;
					}
					case "egal":{
						$op[]="inf";
						$op[]="sup";
						$row2 = $row;
						$row[$nb_variable + $id_eq] = transformation(1);
						$id_eq++;
						$row2[$nb_variable + $id_eq] = transformation(-1);
						$row2[$nb_equation + $nb_equation_suppl + $nb_variable + $nb_variable_artificielle] = transformation(1);
						$nb_variable_artificielle++;
						$id_eq++;
						$matrice[]=$row;
						$matrice[]=$row2;
						$b[]=$b_tmp;
						$b[]=$b_tmp;
						break;
					}
				}
			}
			else{
				switch($operation[$i]){
					
					case "sup" :{
						$op[] = "inf";
						
						$row=oppose($row);
						$row[$nb_variable + $id_eq] = transformation(1);
						$id_eq++;
						$matrice[]=$row;
						$b[] = oppose($b_tmp);
						break;
					}
					case "inf" : {
						$op[]="sup";
						$row=oppose($row);
						$row[$nb_variable + $id_eq] = transformation(-1);
						//$nb_equation_suppl++;
						$row[$nb_equation + $nb_equation_suppl + $nb_variable + $nb_variable_artificielle] = transformation(1);
						$nb_variable_artificielle++;
						$id_eq++;
						$matrice[]=$row;
						//var_dump(oppose($row));
						$b[] = oppose($b_tmp);
						break;
					}
					case "egal":{
						$row = oppose($row);
						$op[]="inf";
						$op[]="sup";
						$row2 = $row;
						$row[$nb_variable + $id_eq] = transformation(1);
						$id_eq++;
						$row2[$nb_variable + $id_eq] = transformation(-1);
						$row2[$nb_equation + $nb_equation_suppl + $nb_variable + $nb_variable_artificielle] = transformation(1);
						$nb_variable_artificielle++;
						$id_eq++;
						$matrice[]=$row;
						$matrice[]=$row2;
						$b[]=oppose($b_tmp);
						$b[]=oppose($b_tmp);
						break;
					}
				}
			}
			
			//var_dump(oppose($row));
		}
		$data['nb_variable_artificielle'] = $nb_variable_artificielle;
		$data['nb_equation_suppl'] = $nb_equation_suppl;
		//var_dump($nb_equation_suppl);
		$data["operation"] = $op;
		$data["matrice"] = $matrice;
		$data["b"] = $b;
		//var_dump($matrice);
		$data["coef_x"] = $coef_x;
		//var_dump($matrice);
		$this->load->view("simplexe/forme_generale",$data);
	}
}