<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('calcul_ZJ'))
{
	function calcul_ZJ($var_coef_base,$matrice,$nb_variable,$nb_equation, $nb_variable_artificielle)
	{
		$ZJ = array();
		for($j=0;$j<$nb_equation+$nb_variable+$nb_variable_artificielle;$j++){
			$z_numerique = 0;
			$z_litterale = 0;
			for($i=0;$i<$nb_equation;$i++){
				$z_litterale = $z_litterale + $var_coef_base[$i]["litterale"]*$matrice[$i][$j];
				$z_numerique = $z_numerique + $var_coef_base[$i]["numerique"]*$matrice[$i][$j];
			}
			$ZJ[$j]["numerique"] = $z_numerique;
			$ZJ[$j]["litterale"] = $z_litterale;
		}
		return $ZJ;
	}
}

if ( ! function_exists('delta_J'))
{
	function delta_J($coef_dans_z,$ZJ,$taille)
	{
		$res = array();
		for($i=0;$i<$taille;$i++){
			$res[$i]["numerique"] = $coef_dans_z[$i]["numerique"] - $ZJ[$i]["numerique"];
			$res[$i]["litterale"] = $coef_dans_z[$i]["litterale"] - $ZJ[$i]["litterale"];
		}
		return $res;
	}
}

if ( ! function_exists('calcul_res_Z'))
{
	function calcul_res_Z($b,$var_coef_base,$taille)
	{
		$res["numerique"] = 0;
		$res["litterale"] = 0;
		for($i=0;$i<$taille;$i++){
			$res['numerique'] = $res['numerique'] + $b[$i]["numerique"]*$var_coef_base[$i]["numerique"];
			$res['litterale'] = $res['litterale'] + $b[$i]["numerique"]*$var_coef_base[$i]["litterale"];
		}
		return $res;
	}
}

if ( ! function_exists('maximum'))
{
	function maximum($tab,$nb_variable_artificielle,$coef_dans_z)
	{
		if(empty($tab)) return false;
		else{
			$res = array();
			$i = 0;
			$max = $tab[0];
			$ind_max = 0;
			$res['value'] = $coef_dans_z[$ind_max];
			$res['indice'] = $ind_max;
			$res['libelle'] = "x".($ind_max+1);
			
			if($nb_variable_artificielle != 0){
				foreach ($tab as $key => $value) {
					if($value["litterale"]>$tab[$ind_max]['litterale']){
						$max = $coef_dans_z[$i];
						$res['value'] = $max;
						$res['indice']= $ind_max = $i;
						$res['libelle'] = "x".($i+1);
					}
					else{
						if($value['litterale'] == $tab[$ind_max]["litterale"]){
							if($value['numerique'] > $tab[$ind_max]['numerique']){
								$max = $value;
								$res['value'] = $coef_dans_z[$i];
								$res['indice']= $ind_max = $i;
								$res['libelle'] = "x".($i+1);
							}
							/*else{
								//var_dump($coef_dans_z[$i]);
								$res['value'] = $coef_dans_z[$i];
								$res['indice'] = $ind_max;
								$res['libelle'] = "x".($ind_max+1);
								}*/
						}
					}
					$i++;
				}
			}
			else{
				foreach ($tab as $key => $value) {
					if($value["numerique"]>$max["numerique"]){
						$max = $value;
						$res['value'] = $coef_dans_z[$i];
						$res['indice'] = $ind_max = $i;
						$res['libelle'] = "x".($i+1);
					}
					$i++;
				}
			}

			//var_dump($res);
			return $res;
		}
	}
}

if ( ! function_exists('suppr_zero'))
{
	function suppr_zero($tab){
		$res = array();
		$i = 0;
		$j=0;
		foreach ($tab as $key => $value) {
			if($value["numerique"]>0 || $value["litterale"]>0) {
				$res[$j]['indice']=$i;
				$res[$j]['value']=$value;
				$j++;
			}
			$i++;
		}
		return $res;
	}
}

if ( ! function_exists('minimum'))
{
	function minimum($tab,$var_coef_base,$nb_variable_artificielle)
	{
		if(empty($tab)) return false;
		else{
			$res = array();
			$tab = suppr_zero($tab);
			$min = $tab[0]['value'];
			$ind_min = $tab[0]['indice'];
			$res['value'] = $min;
			$res['indice'] = $ind_min;
			$res['libelle'] = "x".($var_coef_base[$ind_min]['indice']);

			if($nb_variable_artificielle != 0){
				foreach ($tab as $key => $value) {
					/*
					 * Critère :
					 * Soit (Litterale != 0 && Numerique == 0)
					 * Soit (Litterale == 0 && Numerique != 0)
					 *
					 */

					if($value['value']['numerique'] < $res['value']['numerique']){
						$min = $value["value"];
						$res['value'] = $min;
						$res['indice'] = $value['indice'];
						$res['libelle'] = "x".($var_coef_base[$value['indice']]['indice']);
					}
					else{
						if($value['value']['numerique']==$res['value']['numerique'] && $var_coef_base[$value['indice']]['litterale']!=0 && $var_coef_base[$res['indice']]['numerique']==0){
							$min = $value["value"];
							$res['value'] = $min;
							$res['indice'] = $value['indice'];
							$res['libelle'] = "x".($var_coef_base[$value['indice']]['indice']);
						}
					}





					/*if($var_coef_base[$res['indice']]['litterale'] == 0){
					 	
					if($value['value']['litterale'] != 0){
					if($min['numerique'] != 0){
					$min = $value["value"];
					$res['value'] = $min;
					$res['indice'] = $value['indice'];
					$res['libelle'] = "x".($var_coef_base[$value['indice']]['indice']);
					}
					else{
					if($value['value']['litterale'] <= $min['litterale']){
					$min = $value['value'];
					$res['value'] = $min;
					$res['indice'] = $value['indice'];
					$res['libelle'] = "x".($var_coef_base[$value['indice']]['indice']);
					}
					}

					}
					else{
					if($min['litterale'] == 0 && $min["numerique"] >= $value['value']['numerique']){
					$min = $value['value'];
					$res['value'] = $min;
					$res['indice'] = $value['indice'];
					$res['libelle'] = "x".($var_coef_base[$value['indice']]['indice']);
					}
					}
					}*/

				}
			}
			else {
				foreach ($tab as $key => $value) {
					if($value['value']['litterale'] != 0){
						if($min['numerique'] != 0){
							$min = $value["value"];
							$res['value'] = $min;
							$res['indice'] = $value['indice'];
							$res['libelle'] = "x".($var_coef_base[$value['indice']]['indice']);
						}
						else{
							if($value['value']['litterale'] <= $min['litterale']){
								$min = $value['value'];
								$res['value'] = $min;
								$res['indice'] = $value['indice'];
								$res['libelle'] = "x".($var_coef_base[$value['indice']]['indice']);
							}
						}

					}
					else{
						if($min['litterale'] == 0 && $min["numerique"] >= $value['value']['numerique']){
							$min = $value['value'];
							$res['value'] = $min;
							$res['indice'] = $value['indice'];
							$res['libelle'] = "x".($var_coef_base[$value['indice']]['indice']);
						}
					}
				}
			}
			return $res;
		}
	}
}

if ( ! function_exists('entrant'))
{
	function entrant($delta_J,$coef_dans_z,$nb_variable_artificielle){
		$entrant = maximum($delta_J,$nb_variable_artificielle,$coef_dans_z);
		/*$entrant['value']['numerique'] = $coef_dans_z[$entrant['indice']]['numerique'];
		 $entrant['value']['litterale'] = $coef_dans_z[$entrant['indice']]['litterale'];*/
		return $entrant;
	}
}

if ( ! function_exists('sortant'))
{
	function sortant($b,$matrice,$entrant,$nb_equation, $var_coef_base, $nb_variable_artificielle){
		$rapport = array();
		$indice = $entrant['indice'];
		//echo "indice de l'entrant : ".$indice."<br>";
		//echo "++++++++++++++++++++++++++++++++++<br><br>";
		for($i=0;$i<$nb_equation;$i++){
			//echo "b : " . $b[$i] . "<br>";
			//echo "div : ". $matrice[$i][$indice] . "<br>";
			if($matrice[$i][$indice]!=0) {
				$rapport[$i]["numerique"] = $b[$i]["numerique"]/$matrice[$i][$indice];
				$rapport[$i]["litterale"] = $b[$i]["litterale"]/$matrice[$i][$indice];
			}
			else $rapport[$i]["numerique"] = $rapport[$i]["litterale"] = 0;
			//echo "rapport : ".$rapport[$i] ."<br>";
			//echo "-------------------------------<br>";
		}
		//var_dump($rapport);
		$sortant = minimum($rapport,$var_coef_base,$nb_variable_artificielle);

		return $sortant;
	}
}

if ( ! function_exists('pivot'))
{
	function pivot($matrice,$entrant,$sortant)
	{
		$pivot = array();
		$pivot['ligne'] = $sortant['indice'];
		$pivot['colonne'] = $entrant['indice'];
		$pivot['value'] = $matrice[$sortant["indice"]][$entrant["indice"]];
		return $pivot;
	}
}

if ( ! function_exists('pivotage'))
{
	function pivotage($matrice,$pivot,$var_coef_base,$nb_variable,$nb_equation,$nb_variable_artificielle,$entrant,$b,$coef_dans_z){
		$matrice_new = $matrice;

		//var_dump($var_coef_base);
		$var_coef_base_new = $var_coef_base;
		for($i=0;$i<$nb_equation;$i++){
			for($j=0;$j<$nb_equation+$nb_variable+$nb_variable_artificielle;$j++){
				if(($i!=$pivot['ligne']) && ($j!=$pivot['colonne'])) $matrice_new[$i][$j] = $matrice[$i][$j]-(($matrice[$i][$pivot['colonne']] * $matrice[$pivot['ligne']][$j])/$pivot['value']);
				else{
					if($i!=$pivot['ligne'] && ($j==$pivot['colonne'])) $matrice_new[$i][$j] = 0;
					else $matrice_new[$i][$j] = $matrice[$i][$j]/$pivot['value'];
				}
			}
			if($i==$pivot['ligne']){
				$var_coef_base_new[$i]['numerique'] = $entrant['value']['numerique'];
				$var_coef_base_new[$i]['litterale'] = $entrant['value']['litterale'];
				$var_coef_base_new[$i]['libelle']   = $entrant['libelle'];
				$var_coef_base_new[$i]['indice']    = $entrant['indice'] + 1 ;
			}
		}
		$coef_dans_z_new = $coef_dans_z;
		$indice_sortant = $var_coef_base[$pivot["ligne"]]["indice"];
		if($indice_sortant > $nb_variable+$nb_equation ){
			for($i=0;$i<$nb_equation;$i++) $matrice_new[$i][$indice_sortant-1] = 0;
			$coef_dans_z_new[$indice_sortant-1]["numerique"] = 0;
			$coef_dans_z_new[$indice_sortant-1]["litterale"] = 0;
		}
		$b_new = $b;

		for($i=0;$i<$nb_equation;$i++){
			if($i!=$pivot['ligne']) {
				$b_new[$i]['numerique'] = $b[$i]['numerique'] - (($b[$pivot['ligne']]['numerique']*$matrice[$i][$pivot['colonne']])/$pivot['value']);
				$b_new[$i]['litterale'] = $b[$i]['litterale'] - (($b[$pivot['ligne']]['litterale']*$matrice[$i][$pivot['colonne']])/$pivot['value']);
				/*echo "i : " . $i . "<br>";
				 echo "b : " . $b[$i] . "<br>";
				 echo "pivot : " . $pivot["value"] . "<br>";
				 echo "valeur initiale : " . $matrice[$i][$pivot['colonne']] . '<br><br>';
				 echo "calcul : " . $b[$i] . " - ((" . $b[$pivot['ligne']] . " * " . $matrice[$i][$pivot['colonne']] . ")/" . $pivot['value'].")<br>";
				 echo "b_new : " . $b_new[$i] ."<br>-------------------------------------";*/
			}
			else {
				$b_new[$i]['numerique'] = $b[$i]['numerique']/$pivot['value'];
				$b_new[$i]['litterale'] = $b[$i]['litterale']/$pivot['value'];
				/*echo "i = " . $i ."<br><br>";
				 echo "pivot : " . $pivot["value"] . "<br>";
				 echo "b num : " . $b[$i]["numerique"] . "<br>";
				 echo "b new num : " . $b_new[$i]["numerique"] . "<br>";
				 echo "b litterale : ". $b[$i]["litterale"] . "<br>";
				 echo "b new litterale : ". $b_new[$i]["litterale"] . "<br>------------------------------<br>";*/
			}

			if($b_new[$i]['numerique'] == 0 && $b_new[$i]['litterale'] == 0) $b_new[$i]['litterale'] = 1;
			else{
				if($b_new[$i]["numerique"] != 0 ) $b_new[$i]['litterale'] = 0;
			}
		}
		$data['matrice'] = $matrice_new;
		$data['var_coef_base'] = $var_coef_base_new;
		$data['b'] = $b_new;
		//var_dump($b_new);
		$data["coef_dans_z"] = $coef_dans_z_new;
		return $data;
	}
}

if ( ! function_exists('affichage_expression')){
	function affichage_expression($tab){
		if($tab["numerique"] == 0 && $tab["litterale"] == 0) return "0";
		else {
			if($tab["numerique"] != 0 && $tab["litterale"] == 0) return $tab["numerique"];
			else{
				if($tab["numerique"] == 0 && $tab["litterale"] != 0){
					return litterale($tab["litterale"]);
				}
				else return numerique_litterale($tab["numerique"], $tab["litterale"]);
			}
		}
	}
}

if ( ! function_exists('litterale')){
	function litterale($val){
		$str = "";
		if($val < 0){
			switch ($val){
				case (-1) : $str = "- M"; break;
				default: $str = "- ".(-$val)."M"; break;
			}
		}
		else{
			switch ($val){
				case (1) : $str = "M"; break;
				default: $str = $val ." M"; break;
			}
		}
		return $str;
	}
}

if ( ! function_exists('litterale_numerique')){
	function numerique_litterale($numerique,$litterale){
		$str = $numerique;
		$val = $litterale;
		if($val < 0){
			switch ($val){
				case (-1) : $str = $str . " - M"; break;
				default: $str = $str . " - ".(-$val)."M"; break;
			}
		}
		else{
			switch ($val){
				case (1) : $str = $str . " + M"; break;
				default: $str = $str. " + ". $val ."M"; break;
			}
		}
		return $str;
		//var_dump($str);
	}
}



/*
 * ------------------------------------------------------------
 * ------------------------------------------------------------
 * Affichage des expressions avec epsilone
 * ------------------------------------------------------------
 * ------------------------------------------------------------
 */


if ( ! function_exists('affichage_expression_eps')){
	function affichage_expression_eps($tab){
		if($tab["numerique"] == 0 && $tab["litterale"] == 0) return "0";
		else {
			if($tab["numerique"] != 0 && $tab["litterale"] == 0) return $tab["numerique"];
			else{
				if($tab["numerique"] == 0 && $tab["litterale"] != 0){
					return litterale_eps($tab["litterale"]);
				}
				else return numerique_litterale_eps($tab["numerique"], $tab["litterale"]);
			}
		}
	}
}

if ( ! function_exists('litterale_eps')){
	function litterale_eps($val){
		$str = "";
		if($val < 0){
			switch ($val){
				case (-1) : $str = "- e"; break;
				default: $str = "- ".(-$val)."e"; break;
			}
		}
		else{
			switch ($val){
				case (1) : $str = "e"; break;
				default: $str = $val ." e"; break;
			}
		}
		return $str;
	}
}

if ( ! function_exists('litterale_numerique_eps')){
	function numerique_litterale_eps($numerique,$litterale){
		$str = $numerique;
		$val = $litterale;
		if($val < 0){
			switch ($val){
				case (-1) : $str = $str . " - e"; break;
				default: $str = $str . " - ".(-$val)."e"; break;
			}
		}
		else{
			switch ($val){
				case (1) : $str = $str . " + e"; break;
				default: $str = $str. " + ". $val ."e"; break;
			}
		}
		return $str;
		//var_dump($str);
	}
}

/*if ( ! function_exists('calcul_var_coef_base')){
 function calcul_var_coef_base($nb_equation,$matrice,$var_coef_base){
 $var_coef_base_new = $var_coef_base;

 for($i=0;$i<$nb_equation;$i++){

 }
 }
 }*/