<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class solution extends  MY_Controller {
	function __construct(){
		parent::__construct();
	}

	public function index(){
		$data['nb_variable'] = $nb_variable = $this->input->post('nb_variable');
		$data['nb_equation'] = $nb_equation = $this->input->post('nb_equation');
		$data['type']= $type = $this->input->post('type');
		$matrice=array();
		$coef_dans_z = array();
		$b = array();
		$var_coef_base = array();
		for($i=0;$i<$nb_equation;$i++){
			for($j=0;$j<$nb_variable+$nb_equation;$j++){
				$val = $this->input->post($i.$j) ? $this->input->post($i.$j):"0";
				$matrice[$i][$j] = $val;
				$val = $this->input->post("coef_x".($j+1)) ? $this->input->post("coef_x".($j+1)):"0";
				$coef_dans_z[$j] = $type == 'max' ? $val : (-$val);

				if($j>=$nb_variable) {
					$var_coef_base[$j-$nb_variable]["coef"] = $val;
					$var_coef_base[$j-$nb_variable]["libelle"] = "x".($j+1);
				}
			}
			$b[$i] = $this->input->post("b".$i) ? $this->input->post("b".$i):"0";
		}
		$data['b'] = $b;
		$data['coef_dans_z'] = $coef_dans_z;
		$data['ZJ'] = $ZJ = calcul_ZJ($var_coef_base, $matrice, $nb_variable, $nb_equation);
		$data['delta_J'] = $delat_J = delta_J($coef_dans_z, $ZJ, $nb_equation+$nb_variable);
		$data['Z'] = calcul_res_Z($b, $var_coef_base, $nb_equation);
		$data['var_coef_base']=$var_coef_base;
		$data['matrice'] = $matrice;
		$this->output->set_title('Solution');
		$this->load->view('simplexe/solution',$data);
	}

	public function resolution(){
		$this->output->set_title('Solution');
		$data['nb_equation'] = $nb_equation = $this->input->post('nb_equation');
		$data['nb_variable'] = $nb_variable = $this->input->post('nb_variable');
		$data['type'] = $type = $this->input->post('type');
		$matrice = array();
		$coef_dans_z = array();
		$ZJ = array();
		$var_coef_base = array();
		$delta_J_old = array();
		$b = array();
		for($i=0;$i<$nb_equation;$i++){
			for($j=0;$j<$nb_equation+$nb_variable;$j++){
				$val = $this->input->post($i.$j) ? $this->input->post($i.$j):"0";
				$matrice[$i][$j] = $val;
				$val = $this->input->post("coef_dans_z".$j) ? $this->input->post("coef_dans_z".$j):"0";
				$coef_dans_z[$j] = $val;
				$val = $this->input->post("ZJ".$j) ? $this->input->post("ZJ".$j):"0";
				$ZJ[$j] = $val;
				$val = $this->input->post("DJ".$j) ? $this->input->post("DJ".$j):"0";
				$delta_J_old[$j] = $val;
			}
			$val = $this->input->post("var_coef_base".$i) ? $this->input->post("var_coef_base".$i):"0";
			$var_coef_base[$i]['coef'] = $val;
			$val = $this->input->post("lib_coef_z".$i) ? $this->input->post("lib_coef_z".$i):"0";
			$var_coef_base[$i]['libelle'] = $val;
			$b[$i] = $this->input->post("b".$i) ? $this->input->post("b".$i):"0";
		}
		//$delta_J = delta_J($coef_dans_z, $ZJ, $nb_equation+$nb_variable);
		$entrant = entrant($delta_J_old, $type, $coef_dans_z);
		$sortant = sortant($b, $matrice, $entrant, $nb_equation);
		$pivot = pivot($matrice, $entrant, $sortant);
		$res_tmp = pivotage($matrice, $pivot, $var_coef_base, $nb_variable, $nb_equation, $entrant,$b);
		$data['b']=$res_tmp['b'];
		//$data['ZJ']=$res_tmp['var_coef_base'];
		$data['ZJ'] = $ZJ = calcul_ZJ($res_tmp['var_coef_base'], $res_tmp['matrice'], $nb_variable, $nb_equation);
		$data['delta_J']=delta_J($coef_dans_z, $ZJ, $nb_equation+$nb_variable);
		$data['Z']=calcul_res_Z($res_tmp['b'], $res_tmp['var_coef_base'], $nb_equation);
		$data['matrice']=$res_tmp['matrice'];
		$data['var_coef_base']=$res_tmp['var_coef_base'];
		$data['coef_dans_z']=$coef_dans_z;
		$this->load->view('simplexe/solution',$data);
	}
}