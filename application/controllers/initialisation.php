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
				$tmp = $this->input->post($i.$j) ? $this->input->post($i.$j) : "0/1";
				$tmp = explode('/',$tmp);
				if(count($tmp)==1){
					$val = transformation($tmp[0]);
				}
				else{
					//$test = $tmp[0].'/'.$tmp[1];
					$val = irreductible($tmp[0],$tmp[1]);
					//var_dump($val);
				}

				//$val = $this->input->post($i.$j) ? transformation($this->input->post($i.$j)) : transformation(0);
				$row[$j] = $val;
				//var_dump($val);

				$tmp = $this->input->post("coef_x".($j+1)) ? $this->input->post("coef_x".($j+1)) : '0/1';
				$tmp = explode("/", $tmp);
				if(count($tmp)==1){
					$val = transformation($tmp[0]);
				}
				else{
					$val = irreductible($tmp[0],$tmp[1]);
				}

				$coef_x[$j] = $val;
			}

			$val = $this->input->post("b_numerique".$i) ? $this->input->post("b_numerique".$i) : "0/1";
			$str = explode("/", $val);

			if(count($str)==1){
				$b_numerique = transformation($str[0]);
			}
			else{
				$b_numerique = irreductible($str[0],$str[1]);
			}

			$denom_commun_row = denominateur_commun($row);
			$b_numerique['numerateur'] *= $denom_commun_row;

			/*$b_tmp["numerique"] = $this->input->post("b_numerique".$i) ? transformation($this->input->post("b_numerique".$i)) : transformation(0) ;
			 $b_tmp["litterale"] = transformation(0) ;
			 $denom_commun_row = denominateur_commun($row);
			 $b_tmp['numerique']['numerateur'] *= $denom_commun_row;
			 $b_tmp['litterale']['numerateur'] *= $denom_commun_row;*/

			//var_dump(denominateur_commun($b_tmp));
			//$denom_commun_b = denominateur_commun($b_tmp);

			for($l=0;$l<$nb_variable;$l++){
				$row[$l]['numerateur'] *= (($b_numerique['denominateur']*$denom_commun_row)/$row[$l]['denominateur']);
				$row[$l]['denominateur'] = 1;
			}
			$b_numerique['denominateur']=1;

			$valeur_a_traiter = $row;
			$valeur_a_traiter[]=$b_numerique;

			$pgcd_ligne_courant = pgcd_multiple($valeur_a_traiter, 0);


			for($l=0;$l<$nb_variable;$l++){
				$row[$l]['numerateur'] /= abs($pgcd_ligne_courant);
			}
			$b_numerique['numerateur'] /= abs($pgcd_ligne_courant);

			$b_tmp['numerique'] = $b_numerique;
			$b_tmp['litterale'] = transformation(0);

			$etat_coef_x = etat_coef_x($coef_x);

			if($etat_coef_x['fraction']){
				$ppcm = abs(ppcm_multiple($coef_x, 0));
				for($l=0;$l<$nb_variable;$l++){
					$coef_x[$l] = irreductible_tab(fraction_multiplication($coef_x[$l], transformation($ppcm)));
				}
				$multipl["numerateur"] = 1;
				$multipl["denominateur"] = $ppcm;
			}
			elseif($etat_coef_x['entier']){
				$pgcd_Z = abs(pgcd_multiple($coef_x,0));
				for($l=0;$l<$nb_variable;$l++){
					$coef_x[$l] = irreductible_tab(fraction_division($coef_x[$l], transformation($pgcd_Z)));
				}
				$multipl['numerateur'] = $pgcd_Z;
				$multipl['denominateur'] = 1;
			}

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
		$data['multiplicateur'] = $multipl;
		//var_dump($matrice);
		$this->load->view("simplexe/forme_generale",$data);
	}
}