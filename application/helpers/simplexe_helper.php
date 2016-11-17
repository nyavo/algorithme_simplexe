<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('calcul_ZJ'))
{
	function calcul_ZJ($var_coef_base,$matrice,$nb_variable,$nb_equation)
	{
		$ZJ = array();
		for($j=0;$j<$nb_equation+$nb_variable;$j++){
			$z=0;
			for($i=0;$i<$nb_equation;$i++){
				$z = $z + $var_coef_base[$i]["coef"]*$matrice[$i][$j];
			}
			$ZJ[$j] = $z;
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
			$res[] = $coef_dans_z[$i] - $ZJ[$i];
		}
		return $res;
	}
}

if ( ! function_exists('calcul_res_Z'))
{
	function calcul_res_Z($b,$var_coef_base,$taille)
	{
		$res = 0;
		for($i=0;$i<$taille;$i++){
			$res = $res + $b[$i]*$var_coef_base[$i]["coef"];
		}
		return $res;
	}
}

if ( ! function_exists('maximum'))
{
	function maximum($tab)
	{
		if(empty($tab)) return false;
		else{
			$res = array();
			$i = 0;
			$max = $tab[0];
			foreach ($tab as $key => $value) {
				if($value>=$max){
					$max = $value;
					$res['value'] = $max;
					$res['indice']= $i;
					$res['libelle'] = "x".($i+1);
				}
				$i++;
			}
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
			if($value>0) {
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
	function minimum($tab)
	{
		if(empty($tab)) return false;
		else{
			$res = array();
			$tab = suppr_zero($tab);
			$min = $tab[0]['value'];
			foreach ($tab as $key => $value) {
				if($value['value']<=$min){
					$min = $value['value'];
					$res['value'] = $min;
					$res['indice'] = $value['indice'];
					$res['libelle'] = "x".($value['indice']+1);
				}
			}
			return $res;
		}
	}
}

if ( ! function_exists('entrant'))
{
	function entrant($delta_J,$type,$coef_dans_z){
		if($type=='max') $entrant = maximum($delta_J);
		else $entrant = minimum($delta_J);

		$entrant['value']=$coef_dans_z[$entrant['indice']];
		return $entrant;
	}
}

if ( ! function_exists('sortant'))
{
	function sortant($b,$matrice,$entrant,$nb_equation){
		$rapport = array();
		$indice = $entrant['indice'];
		for($i=0;$i<$nb_equation;$i++)
		{
			if($matrice[$i][$indice]!=0) {
				$rapport[$i] = $b[$i]/$matrice[$i][$indice];
			}
			else $rapport[$i]=0;
		}
		$sortant = minimum($rapport);
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
	function pivotage($matrice,$pivot,$var_coef_base,$nb_variable,$nb_equation,$entrant,$b){

		$matrice_new = $matrice;
		$var_coef_base_new = $var_coef_base;
		for($i=0;$i<$nb_equation;$i++){
			for($j=0;$j<$nb_equation+$nb_variable;$j++){
				if(($i!=$pivot['ligne']) && ($j!=$pivot['colonne'])) $matrice_new[$i][$j] = $matrice[$i][$j]-(($matrice[$i][$pivot['colonne']] * $matrice[$pivot['ligne']][$j])/$pivot['value']);
				else{
					if($i!=$pivot['ligne'] && ($j==$pivot['colonne'])) $matrice_new[$i][$j] = 0;
					else $matrice_new[$i][$j] = $matrice[$i][$j]/$pivot['value'];
				}
			}
			if($i==$pivot['ligne']){
				$var_coef_base_new[$i]['coef'] = $entrant['value'];
				$var_coef_base_new[$i]['libelle']=$entrant['libelle'];
			}
		}

		$b_new = $b;

		for($i=0;$i<$nb_equation;$i++){
			if($i!=$pivot['ligne']) {
				$b_new[$i] = $b[$i] - (($b[$pivot['ligne']]*$matrice[$i][$pivot['colonne']])/$pivot['value']);
			}
			else {
				$b_new[$i] = $b[$i]/$pivot['value'];
			}
		}
		$data['matrice'] = $matrice_new;
		$data['var_coef_base'] = $var_coef_base_new;
		$data['b'] = $b_new;
		return $data;
		var_dump($data);
	}
}

/*if ( ! function_exists('calcul_var_coef_base')){
 function calcul_var_coef_base($nb_equation,$matrice,$var_coef_base){
 $var_coef_base_new = $var_coef_base;

 for($i=0;$i<$nb_equation;$i++){
 	
 }
 }
 }*/