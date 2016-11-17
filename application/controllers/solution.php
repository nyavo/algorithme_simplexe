<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class solution extends  MY_Controller {
	function __construct(){
		parent::__construct();
	}

	public function index(){
		$data['nb_variable'] = $nb_variable = $this->input->post('nb_variable');
		$nb_equation = $this->input->post('nb_equation');
		$data['nb_equation_suppl'] = $nb_equation_suppl = $this->input->post('nb_equation_suppl');
		$data['nb_variable_artificielle'] = $nb_variable_artificielle = $this->input->post('nb_variable_artificielle');
		$data['type']= $type = $this->input->post('type');

		$multiplicateur = $this->input->post('multiplicateur');
		$multiplicateur = explode('/', $multiplicateur);
		$data['multiplicateur']['numerateur'] = $multiplicateur[0];
		$data['multiplicateur']['denominateur'] = $multiplicateur[1];

		$matrice=array();
		$nb_equation += $nb_equation_suppl;
		$data['nb_equation'] = $nb_equation;
		$coef_dans_z = array();
		$b = array();
		$var_coef_base = array();
		$operation = array();
		for($i=0;$i<$nb_equation;$i++){
			$operation[$i] = $this->input->post('operation'.($i+1));
			for($j=0;$j<$nb_variable+$nb_equation+$nb_variable_artificielle;$j++){
				$val = $this->input->post($i.$j) ? $this->input->post($i.$j):"0/1";
				$str = explode("/", $val);
				$matrice[$i][$j]['numerateur'] = $str[0];
				$matrice[$i][$j]['denominateur'] = $str[1];
				if($j<$nb_variable+$nb_equation){
					$val = $this->input->post("coef_x".($j+1)) ? $this->input->post("coef_x".($j+1)): "0/1" ;
					$str = explode("/", $val);
					$coef_dans_z[$j]["numerique"]['numerateur'] = $str[0];
					$coef_dans_z[$j]["numerique"]['denominateur'] = $str[1];
					$coef_dans_z[$j]["litterale"] = transformation(0);
				}
				else{
					//$val = "- M";
					$coef_dans_z[$j]["numerique"] = transformation(0);
					$coef_dans_z[$j]["litterale"] = transformation(-1);
				}
				//$coef_dans_z[$j] = $val;
			}
			$val = $this->input->post("b_numerique".$i) ?  $this->input->post("b_numerique".$i) : "0/1";
			$str = explode("/", $val);
			$b[$i]['numerique']['numerateur'] = $str[0];
			$b[$i]['numerique']['denominateur'] = $str[1];

			$val = $this->input->post("b_litterale".$i) ?  $this->input->post("b_litterale".$i) : "0/1";
			$str = explode("/", $val);
			$b[$i]['litterale']['numerateur'] = $str[0];
			$b[$i]['litterale']['denominateur'] = $str[1];
		}
		//var_dump($matrice);
		//initialisation des variables de bases
		$j=0;
		for($i=0;$i<$nb_equation;$i++){
			if($operation[$i]=="inf"){
				$var_coef_base[$i]["numerique"] = $coef_dans_z[$nb_variable + $j]["numerique"];
				$var_coef_base[$i]["litterale"] = $coef_dans_z[$nb_variable + $j]["litterale"];
				$var_coef_base[$i]["libelle"] = "x<sub>".($nb_variable + $i + 1)."</sub";
				$var_coef_base[$i]["indice"] = $nb_variable + $i + 1;

			}
			else{
				$var_coef_base[$i]["numerique"] = $coef_dans_z[$nb_variable + $nb_equation + $j]["numerique"];
				$var_coef_base[$i]["litterale"] = $coef_dans_z[$nb_variable + $nb_equation + $j]["litterale"];
				$var_coef_base[$i]["libelle"] = "x<sub>".($nb_variable + $nb_equation + $j+1)."</sub>";
				$var_coef_base[$i]["indice"] = $nb_variable + $nb_equation + $j;
				$j++;
			}
		}

		$data['operation'] = $operation;
		$data['b'] = $b;
		$data['coef_dans_z'] = $coef_dans_z;
		//var_dump($coef_dans_z);

		//var_dump($var_coef_base);
		$data['ZJ'] = $ZJ = calcul_ZJ($var_coef_base, $matrice, $nb_variable, $nb_equation, $nb_variable_artificielle);
		//var_dump($ZJ);
		$data['delta_J'] = $delta_J = delta_J($coef_dans_z, $ZJ, $nb_equation+$nb_variable+$nb_variable_artificielle);
		//var_dump($delta_J);
		$data['Z'] = calcul_res_Z($b, $var_coef_base, $nb_equation);
		//var_dump(calcul_res_Z($b, $var_coef_base, $nb_equation));
		$data['var_coef_base']=$var_coef_base;
		//var_dump($var_coef_base);

		/*
		 * Vérification des résultats si contraintes incompatibles
		 */


		/*
		 * Fin vérification
		 */


		$entrant = entrant($delta_J, $coef_dans_z, $nb_variable_artificielle);
		//var_dump($entrant);
		$sortant = sortant($b, $matrice, $entrant, $nb_equation, $var_coef_base, $nb_variable_artificielle);
		//var_dump($sortant);
		$pivot = pivot($matrice, $entrant, $sortant);
		//var_dump($pivot);

		if($delta_J[$entrant['indice']]['numerique']['numerateur']==0 && $delta_J[$entrant['indice']]['litterale']['numerateur']==0){
			$data['ok'] = false;
			$data['pas_de_solution'] = true;
		}

		$data['entrant'] = $entrant;
		$data['sortant'] = $sortant;
		$data['pivot'] = $pivot;
		for($i=0;$i<$nb_equation;$i++){
			if($matrice[$i][$pivot['colonne']]['numerateur']!=0) {
				$rapport[$i]["numerique"] = fraction_division($b[$i]["numerique"],$matrice[$i][$pivot['colonne']]);
				$rapport[$i]["litterale"] = fraction_division($b[$i]["litterale"],$matrice[$i][$pivot['colonne']]);
			}
			else $rapport[$i]["numerique"] = $rapport[$i]["litterale"] = transformation(0);
		}
		$data['rapport'] = $rapport;
		$data['matrice'] = $matrice;
		//var_dump($matrice);
		$this->output->set_title('Solution');
		$this->load->view('simplexe/solution',$data);
	}

	public function resolution(){
		$this->output->set_title('Solution');
		$data['nb_equation'] = $nb_equation = $this->input->post('nb_equation');
		$data['nb_variable'] = $nb_variable = $this->input->post('nb_variable');
		$data['nb_variable_artificielle'] = $nb_variable_artificielle = $this->input->post("nb_variable_artificielle");
		$data['type'] = $type = $this->input->post('type');
		$multiplicateur = $this->input->post('multiplicateur');
		$multiplicateur = explode('/', $multiplicateur);
		$data['multiplicateur']['numerateur'] = $multiplicateur[0];
		$data['multiplicateur']['denominateur'] = $multiplicateur[1];
		$matrice = array();
		$coef_dans_z = array();
		$ZJ = array();
		$var_coef_base = array();
		$delta_J_old = array();
		$b = array();

		//initialisation de la matrice et des coefficients et des contraintes B
		for($i=0;$i<$nb_equation;$i++){
			for($j=0;$j<$nb_equation+$nb_variable+$nb_variable_artificielle;$j++){
				$val = $this->input->post($i.$j) ? $this->input->post($i.$j): "0/1" ;
				$str = explode("/", $val);
				$matrice[$i][$j]['numerateur'] = $str[0];
				$matrice[$i][$j]['denominateur'] = $str[1];
			}
			$num = $this->input->post("var_coef_base_numerique".$i) ? $this->input->post("var_coef_base_numerique".$i):"0/1";
			$litter = $this->input->post("var_coef_base_litterale".$i) ? $this->input->post("var_coef_base_litterale".$i):"0/1";
			$num = explode("/", $num);
			$litter = explode("/", $litter);
			$var_coef_base[$i]['numerique']['numerateur'] = $num[0];
			$var_coef_base[$i]['numerique']['denominateur'] = $num[1];
			$var_coef_base[$i]['litterale']['numerateur'] = $litter[0];
			$var_coef_base[$i]['litterale']['denominateur'] = $litter[1];
			$val = $this->input->post("lib_coef_z".$i) ? $this->input->post("lib_coef_z".$i):"0";
			$var_coef_base[$i]['libelle'] = $val;
			$val = $this->input->post("indice".$i) ? $this->input->post("indice".$i):"0";
			$var_coef_base[$i]['indice'] = $val;
			$val = $this->input->post("b_numerique".$i) ? $this->input->post("b_numerique".$i):"0/1";
			$str = explode("/", $val);
			$b[$i]["numerique"]['numerateur'] = $str[0];
			$b[$i]["numerique"]['denominateur'] = $str[1];

			$val = $this->input->post("b_litterale".$i) ? $this->input->post("b_litterale".$i):"0/1";
			$str = explode("/", $val);
			$b[$i]["litterale"]['numerateur'] = $str[0];
			$b[$i]["litterale"]['denominateur'] = $str[1];
		}

		for($j=0;$j<$nb_equation+$nb_variable+$nb_variable_artificielle;$j++){
			//initialisation de la coefficient dans z

			$num = $this->input->post("coef_dans_z_numerique".$j) ? $this->input->post("coef_dans_z_numerique".$j):"0/1";
			$litter = $this->input->post("coef_dans_z_litterale".$j) ? $this->input->post("coef_dans_z_litterale".$j):"0/1";
			$str = explode("/", $num);
			$coef_dans_z[$j]["numerique"]["numerateur"] = $str[0];
			$coef_dans_z[$j]["numerique"]["denominateur"] = $str[1];
			$str = explode("/", $litter);
			$coef_dans_z[$j]["litterale"]['numerateur'] = $str[0];
			$coef_dans_z[$j]["litterale"]['denominateur'] = $str[1];

			//initialisation de Zj
			$num = $this->input->post("ZJ_numerique".$j) ? $this->input->post("ZJ_numerique".$j): "0/1" ;
			$litter = $this->input->post("ZJ_litterale".$j) ? $this->input->post("ZJ_litterale".$j): "0/1" ;
			$str = explode("/",$num);
			$ZJ[$j]["numerique"]['numerateur'] = $str[0];
			$ZJ[$j]["numerique"]['denominateur'] = $str[1];
			$str = explode("/",$litter);
			$ZJ[$j]["litterale"]['numerateur'] = $str[0];
			$ZJ[$j]["litterale"]['denominateur'] = $str[1];

			//initialisation de deltaJ
			$num = $this->input->post("DJ_numerique".$j) ? $this->input->post("DJ_numerique".$j):"0/1";
			$litter = $this->input->post("DJ_litterale".$j) ? $this->input->post("DJ_litterale".$j):"0/1";
			$str = explode('/',$num);
			$delta_J_old[$j]["numerique"]['numerateur'] = $str[0];
			$delta_J_old[$j]["numerique"]['denominateur'] = $str[1];
			$str = explode('/',$litter);
			$delta_J_old[$j]["litterale"]['numerateur'] = $str[0];
			$delta_J_old[$j]["litterale"]['denominateur'] = $str[1];
		}
		//$delta_J = delta_J($coef_dans_z, $ZJ, $nb_equation+$nb_variable);
		$data['entrant'] = $entrant = entrant($delta_J_old, $coef_dans_z, $nb_variable_artificielle);
		//var_dump($entrant);
		//var_dump($matrice);
		$data['sortant'] = $sortant = sortant($b, $matrice, $entrant, $nb_equation, $var_coef_base, $nb_variable_artificielle);
		//var_dump($sortant);
		$pivot = pivot($matrice, $entrant, $sortant);
		$data['pivot'] = $pivot;
		//var_dump($pivot);
		$res_tmp = pivotage($matrice, $pivot, $var_coef_base, $nb_variable, $nb_equation, $nb_variable_artificielle, $entrant,$b,$coef_dans_z);
		//var_dump($res_tmp['matrice']);
		$data['b']=$res_tmp['b'];
		//$data['ZJ']=$res_tmp['var_coef_base'];
		$data['ZJ'] = $ZJ = calcul_ZJ($res_tmp['var_coef_base'], $res_tmp['matrice'], $nb_variable, $nb_equation, $nb_variable_artificielle);
		//var_dump($ZJ);
		$data['delta_J']= $a = delta_J($res_tmp["coef_dans_z"], $ZJ, $nb_equation+$nb_variable+$nb_variable_artificielle);
		//var_dump($a);
		$data['Z']=calcul_res_Z($res_tmp['b'], $res_tmp['var_coef_base'], $nb_equation);
		$data['matrice']=$res_tmp['matrice'];

		/*
		 * calcul du nouveau pivot
		 */

		$entrant = entrant($a, $coef_dans_z, $nb_variable_artificielle);
		$sortant = sortant($res_tmp['b'], $res_tmp['matrice'], $entrant, $nb_equation, $res_tmp['var_coef_base'], $nb_variable_artificielle);
		$data['pivot'] = $pivot_new = pivot($res_tmp['matrice'], $entrant, $sortant);

		/*
		 * fin calcul
		 */
		if($a[$entrant['indice']]['numerique']['numerateur']==0 && $a[$entrant['indice']]['litterale']['numerateur']==0){
			$data['ok'] = true;
			$resultat = array();
			//var_dump($res_tmp['var_coef_base']);
			for($t=0;$t<$nb_variable;$t++){
				$trouve = false;
				$l = 0;
				foreach ($res_tmp['var_coef_base'] as $value) {
					if($value['indice'] == $t+1){
						$trouve = true;
						$resultat[$t] = $res_tmp['b'][$l];
						break;
					}
					$l++;
				}
				if($trouve==false){
					$tmp['numerique'] = $tmp['litterale'] = transformation(0);
					$resultat[$t]=$tmp;
					//var_dump($a);
				}
			}
			$data['resultat'] = $resultat;
		}

		for($i=0;$i<$nb_equation;$i++){
			if($res_tmp['matrice'][$i][$pivot_new['colonne']]['numerateur']!=0) {
				$rapport[$i]["numerique"] = fraction_division($res_tmp['b'][$i]["numerique"],$res_tmp['matrice'][$i][$pivot_new['colonne']]);
				$rapport[$i]["litterale"] = fraction_division($res_tmp['b'][$i]["litterale"],$res_tmp['matrice'][$i][$pivot_new['colonne']]);
			}
			else $rapport[$i]["numerique"] = $rapport[$i]["litterale"] = transformation(0);
		}
		$data['rapport'] = $rapport;

		$data['var_coef_base']=$res_tmp['var_coef_base'];
		$data['coef_dans_z']=$res_tmp["coef_dans_z"];
		$this->load->view('simplexe/solution',$data);
	}
}