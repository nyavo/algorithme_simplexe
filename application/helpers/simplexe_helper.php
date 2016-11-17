<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('calcul_ZJ'))
{
	function calcul_ZJ($var_coef_base,$matrice,$nb_variable,$nb_equation, $nb_variable_artificielle)
	{
		$ZJ = array();
		for($j=0;$j<$nb_equation+$nb_variable+$nb_variable_artificielle;$j++){
			$z_numerique = transformation(0);
			$z_litterale = transformation(0);
			for($i=0;$i<$nb_equation;$i++){
				$z_litterale = fraction_addition($z_litterale,fraction_multiplication($var_coef_base[$i]["litterale"],$matrice[$i][$j]));
				$z_numerique = fraction_addition($z_numerique,fraction_multiplication($var_coef_base[$i]["numerique"],$matrice[$i][$j]));
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
			$res[$i]["numerique"] = fraction_soustraction($coef_dans_z[$i]["numerique"],$ZJ[$i]["numerique"]);
			$res[$i]["litterale"] = fraction_soustraction($coef_dans_z[$i]["litterale"],$ZJ[$i]["litterale"]);
		}
		return $res;
	}
}

if ( ! function_exists('calcul_res_Z'))
{
	function calcul_res_Z($b,$var_coef_base,$taille)
	{
		$res["numerique"] = transformation(0);
		$res["litterale"] = transformation(0);
		for($i=0;$i<$taille;$i++){
			$res['numerique'] = fraction_addition($res['numerique'],fraction_multiplication($b[$i]["numerique"],$var_coef_base[$i]["numerique"]));
			$res['litterale'] = fraction_addition($res['litterale'],fraction_multiplication($b[$i]["numerique"],$var_coef_base[$i]["litterale"]));
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
					if(compare_fraction($value["litterale"],$tab[$ind_max]['litterale'])==1){
						$max = $coef_dans_z[$i];
						$res['value'] = $max;
						$res['indice']= $ind_max = $i;
						$res['libelle'] = "x".($i+1);
					}
					else{
						if(compare_fraction($value['litterale'],$tab[$ind_max]["litterale"])==0){
							if(compare_fraction($value['numerique'], $tab[$ind_max]['numerique'])==1){
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
					if(compare_fraction($value["numerique"],$max["numerique"])==1){
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
			if($value["numerique"]['numerateur']>0 || $value["litterale"]['numerateur']>0) {
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

					if(compare_fraction($value['value']['numerique'],$res['value']['numerique'])==-1){
						$min = $value["value"];
						$res['value'] = $min;
						$res['indice'] = $value['indice'];
						$res['libelle'] = "x".($var_coef_base[$value['indice']]['indice']);
					}
					else{
						if(compare_fraction($value['value']['numerique'],$res['value']['numerique'])==0 && affichage_fraction($var_coef_base[$value['indice']]['litterale'])!=0 && affichage_fraction($var_coef_base[$res['indice']]['numerique'])==0){
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
					if($value['value']['litterale']['numerateur'] != 0){
						if($min['numerique']['numerateur'] != 0){
							$min = $value["value"];
							$res['value'] = $min;
							$res['indice'] = $value['indice'];
							$res['libelle'] = "x".($var_coef_base[$value['indice']]['indice']);
						}
						else{
							if(compare_fraction($value['value']['litterale'],$min['litterale']) <= 0){
								$min = $value['value'];
								$res['value'] = $min;
								$res['indice'] = $value['indice'];
								$res['libelle'] = "x".($var_coef_base[$value['indice']]['indice']);
							}
						}

					}
					else{
						if($min['litterale']['numerateur'] == 0 && compare_fraction($min["numerique"],$value['value']['numerique']) >= 0){
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
			if($matrice[$i][$indice]['numerateur']!=0) {
				$rapport[$i]["numerique"] = fraction_division($b[$i]["numerique"],$matrice[$i][$indice]);
				$rapport[$i]["litterale"] = fraction_division($b[$i]["litterale"],$matrice[$i][$indice]);
			}
			else $rapport[$i]["numerique"] = $rapport[$i]["litterale"] = transformation(0);
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
				if(($i!=$pivot['ligne']) && ($j!=$pivot['colonne'])) $matrice_new[$i][$j] = fraction_soustraction($matrice[$i][$j],(fraction_division(fraction_multiplication($matrice[$i][$pivot['colonne']],$matrice[$pivot['ligne']][$j]),$pivot['value'])));
				else{
					if($i!=$pivot['ligne'] && ($j==$pivot['colonne'])) $matrice_new[$i][$j] = transformation(0);
					else $matrice_new[$i][$j] = fraction_division($matrice[$i][$j],$pivot['value']);
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
			for($i=0;$i<$nb_equation;$i++) $matrice_new[$i][$indice_sortant-1] = transformation(0);
			$coef_dans_z_new[$indice_sortant-1]["numerique"] = transformation(0);
			$coef_dans_z_new[$indice_sortant-1]["litterale"] = transformation(0);
		}
		$b_new = $b;

		for($i=0;$i<$nb_equation;$i++){
			if($i!=$pivot['ligne']) {
				$b_new[$i]['numerique'] = fraction_soustraction($b[$i]['numerique'], fraction_division(fraction_multiplication($b[$pivot['ligne']]['numerique'],$matrice[$i][$pivot['colonne']]),$pivot['value']));
				$b_new[$i]['litterale'] = fraction_soustraction($b[$i]['litterale'], fraction_division(fraction_multiplication($b[$pivot['ligne']]['litterale'],$matrice[$i][$pivot['colonne']]),$pivot['value']));
				/*echo "i : " . $i . "<br>";
				 echo "b : " . $b[$i] . "<br>";
				 echo "pivot : " . $pivot["value"] . "<br>";
				 echo "valeur initiale : " . $matrice[$i][$pivot['colonne']] . '<br><br>';
				 echo "calcul : " . $b[$i] . " - ((" . $b[$pivot['ligne']] . " * " . $matrice[$i][$pivot['colonne']] . ")/" . $pivot['value'].")<br>";
				 echo "b_new : " . $b_new[$i] ."<br>-------------------------------------";*/
			}
			else {
				$b_new[$i]['numerique'] = fraction_division($b[$i]['numerique'],$pivot['value']);
				$b_new[$i]['litterale'] = fraction_division($b[$i]['litterale'],$pivot['value']);
				/*echo "i = " . $i ."<br><br>";
				 echo "pivot : " . $pivot["value"] . "<br>";
				 echo "b num : " . $b[$i]["numerique"] . "<br>";
				 echo "b new num : " . $b_new[$i]["numerique"] . "<br>";
				 echo "b litterale : ". $b[$i]["litterale"] . "<br>";
				 echo "b new litterale : ". $b_new[$i]["litterale"] . "<br>------------------------------<br>";*/
			}

			if($b_new[$i]['numerique']['numerateur'] == 0 && $b_new[$i]['litterale']['numerateur'] == 0) $b_new[$i]['litterale'] = transformation(1);
			else{
				if($b_new[$i]["numerique"]['numerateur'] != 0 ) $b_new[$i]['litterale'] = transformation(0);
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
		if($tab["numerique"]['numerateur'] == 0 && $tab["litterale"]['numerateur'] == 0) return "0";
		else {
			if($tab["numerique"]['numerateur'] != 0 && $tab["litterale"]['numerateur'] == 0) return affichage_fraction($tab["numerique"]);
			else{
				if($tab["numerique"]['numerateur'] == 0 && $tab["litterale"]['numerateur'] != 0){
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
		if(signe($val) < 0){
			switch (affichage_fraction($val)){
				case (-1) : $str = "- M"; break;
				default: $str = affichage_fraction($val)."M"; break;
			}
		}
		else{
			switch (affichage_fraction($val)){
				case (1) : $str = "M"; break;
				default: $str = affichage_fraction($val) ." M"; break;
			}
		}
		return $str;
	}
}

if ( ! function_exists('litterale_numerique')){
	function numerique_litterale($numerique,$litterale){
		$str = affichage_fraction($numerique);
		$val = $litterale;
		if(signe($val) < 0){
			switch (affichage_fraction($val)){
				case (-1) : $str = $str . " - M"; break;
				default: $str = $str . " ".affichage_fraction($val)."M"; break;
			}
		}
		else{
			switch (affichage_fraction($val)){
				case (1) : $str = $str . " + M"; break;
				default: $str = $str. " + ". affichage_fraction($val) ."M"; break;
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
		if($tab["numerique"]['numerateur'] == 0 && $tab["litterale"]['numerateur'] == 0) return "0";
		else {
			if($tab["numerique"]['numerateur'] != 0 && $tab["litterale"]['numerateur'] == 0) return affichage_fraction($tab["numerique"]);
			else{
				if($tab["numerique"]['numerateur'] == 0 && $tab["litterale"]['numerateur'] != 0){
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
		if(signe($val) < 0){
			switch (affichage_fraction($val)){
				case (-1) : $str = "- e"; break;
				default: $str = affichage_fraction($val)."e"; break;
			}
		}
		else{
			switch (affichage_fraction($val)){
				case (1) : $str = "e"; break;
				default: $str = affichage_fraction($val) ." e"; break;
			}
		}
		return $str;
	}
}

if ( ! function_exists('litterale_numerique_eps')){
	function numerique_litterale_eps($numerique,$litterale){
		$str = affichage_fraction($numerique);
		$val = $litterale;
		if(signe($val) < 0){
			switch (affichage_fraction($val)){
				case (-1) : $str = $str . " - e"; break;
				default: $str = $str . " ".affichage_fraction($val)."e"; break;
			}
		}
		else{
			switch (affichage_fraction($val)){
				case (1) : $str = $str . " + e"; break;
				default: $str = $str. " + ". affichage_fraction($val) ."e"; break;
			}
		}
		return $str;
		//var_dump($str);
	}
}

//calcul des nombres premiers inférieurs à un nombre
/*if ( ! function_exists('nombres_premiers')){
 function nombres_premiers($nb){
 if($nb == 1){
 $pr[]=$nb;
 return $pr;
 }
 else{
 for($i=2;$i<=$nb;$i++) $pr[]=$i;
 //var_dump($pr);
 return init_tab($pr);
 }
 }
 }

 /*if ( ! function_exists('init_tab')){
 function init_tab($tab){
 $t = 0;
 //while($tab != null){
 while($t<1000){
 $a = $premier[] = $tab[0];
 $tab[0]=0;
 for($i=1;$i<count($tab);$i++){
 if($tab[$i]==($a*$a) || ($tab[$i]>($a*$a)&&($tab[$i]%$a == 0))) $tab[$i] = 0;
 }
 $tab = rm_zero($tab);
 $t++;
 }
 return $premier;
 }
 }
 /*
 if ( ! function_exists('rm_zero')){
 function rm_zero($tab){
 $res = array();
 foreach ($tab as $key => $value) {
 if($value>0) $res[]=$value;
 }
 return $res;
 }
 }

 /*if ( ! function_exists('decomposition')){
 function decomposition($nb){
 $res = array();
 $premier = nombres_premiers($nb);
 $a = 0;
 if($premier[0] == 1){
 $res[$a]['valeur'] = 1;
 $res[$a]['occurence'] = 1;
 }
 else{
 for($i=0 ; $i<count($premier) ; $i++ ) {

 $j=0;
 while($nb % $premier[$i] == 0){
 $nb = $nb/$premier[$i];
 $j++;
 }
 if($j>0){
 $res[$a]['valeur'] = $premier[$i];
 $res[$a]['occurence'] = $j;
 $a++;
 }
 }
 }
 return $res;
 }
 }*/

/*if ( ! function_exists('fraction_irreductible')){
 function fraction_irreductible($numerateur,$denominateur){
 $num = $numerateur > 0 ? decomposition($numerateur) : decomposition(-$numerateur);
 $denom = $denominateur > 0 ? decomposition($denominateur) : decomposition(-$denominateur);
 //var_dump($num);
 for ($i=0;$i<count($num);$i++){
 for ($j=0;$j<count($denom);$j++){
 if($num[$i]['valeur'] == $denom[$j]['valeur']){
 if($num[$i]['occurence']<=$denom[$j]['occurence']){
 $a = $num[$i]['occurence'];
 $num[$i]['occurence'] -= $a;
 $denom[$j]['occurence'] -= $a;
 }
 else{
 $a = $denom[$j]['occurence'];
 $num[$i]['occurence'] -= $a;
 $denom[$j]['occurence'] -= $a;
 }
 }
 }
 }
 if(($numerateur*$denominateur)>0)$data['numerateur'] = calcul_nombre($num);
 else $data['numerateur'] = - calcul_nombre($num);
 //var_dump($denom);
 $data['denominateur'] = calcul_nombre($denom);
 return $data;
 }
 }

 if ( ! function_exists('calcul_nombre')){
 function calcul_nombre($nombre){
 $produit = 1;
 foreach ($nombre as $key => $value) {
 $produit *= pow($value['valeur'], $value['occurence']);
 }
 return $produit;
 }
 }*/

if ( ! function_exists('transformation')){
	function transformation($nombre){
		$a = (float)$nombre;
		$l1 = strlen((string) $a);
		//echo $a ."<br>";
		$a = (int) $nombre;
		$l2 = strlen((string) $a);
		//echo $a."<br>";
		//$nbr_chiffre_apres_virgule = 0;
		if($l1 != $l2) {
			$nbr_chiffre_apres_virgule = $l1 - $l2 - 1;
		}
		else{
			$nbr_chiffre_apres_virgule = $l1 - $l2;
		}

		//var_dump($nbr_chiffre_apres_virgule);
		if($nbr_chiffre_apres_virgule > 0){
			$num = $nombre * pow(10,$nbr_chiffre_apres_virgule);
			//var_dump($denom);
			$denom = pow(10,$nbr_chiffre_apres_virgule);
			//if($num*$denom)
			$res = irreductible($num, $denom);
		}
		else{
			$res['numerateur'] = $nombre;
			$res['denominateur'] = 1;
		}
		return $res;
	}
}

if ( ! function_exists('pgcd')){
	function pgcd($nombre,$nombre2){
		/*$i = 1;
		 while($nombre>1){
			$reste = $nombre%$nombre2;
			if($reste == 0){
			break; // sorti quand resultat trouvé
			}

			$nombre=$nombre2;
			$nombre2=$reste;
			}
			return $nombre2; // retourne le resultat
			*/

		if($nombre2 == 0 && $nombre != 0) return $nombre;
		elseif ($nombre2 == 0 && $nombre == 0 ) return 1;
		else return pgcd($nombre2,$nombre%$nombre2);
	}
}

if ( ! function_exists('ppcm')){
	function ppcm($nombre,$nombre2){
		//if(($nombre =! "0") && ($nombre2 =! "0")){
			$ppcm = ($nombre*$nombre2)/pgcd($nombre, $nombre2);
			//echo "(".$nombre ."*".$nombre2.")/".pgcd($nombre, $nombre2).'<br>';
		//}
		//else $ppcm = 1;
		
		$ppcm = $ppcm==0 ? 1 : $ppcm;
		return $ppcm;
	}
}

if ( ! function_exists('irreductible')){
	function irreductible($num,$denom){
		if($num>$denom){
			if($num >= 0) $pgcd = pgcd($num, $denom);
			else $pgcd = pgcd(-$num, $denom);
		}
		else{
			if($num >= 0) $pgcd = pgcd($denom, $num);
			else $pgcd = pgcd($denom, -$num);
		}

		//var_dump($pgcd);
		if($pgcd != 1){
			$res['numerateur'] = $num / $pgcd ;
			$res['denominateur'] = $denom / $pgcd ;
		}
		else{
			$res['numerateur'] = $num ;
			$res['denominateur'] = $denom ;
		}
		return $res;
	}
}

if ( ! function_exists('irreductible_tab')){
	function irreductible_tab($tab){
		$num = $tab['numerateur'];
		$denom = $tab['denominateur'];
		if($num>$denom){
			if($num >= 0) $pgcd = pgcd($num, $denom);
			else $pgcd = pgcd(-$num, $denom);
		}
		else{
			if($num >= 0) $pgcd = pgcd($denom, $num);
			else $pgcd = pgcd($denom, -$num);
		}

		//var_dump($pgcd);
		if($pgcd != 1){
			$res['numerateur'] = $num / $pgcd ;
			$res['denominateur'] = $denom / $pgcd ;
		}
		else{
			$res['numerateur'] = $num ;
			$res['denominateur'] = $denom ;
		}
		return $res;
	}
}

if ( ! function_exists('affiche_fraction')){
	function affichage_fraction($fraction){
		if($fraction["numerateur"] == 0) return 0;
		else{
			if(abs($fraction["denominateur"]) == 1) {
				if(signe($fraction)< 0)return filtre_nombre(-abs($fraction["numerateur"]));
				else return filtre_nombre(abs($fraction['numerateur']));
			}
			else {
				if($fraction['numerateur'] * $fraction['denominateur'] < 0) return "-(". filtre_nombre(abs($fraction['numerateur'])) ."/" . filtre_nombre(abs($fraction['denominateur'])) . ")";
				else return "(". filtre_nombre(abs($fraction['numerateur'])) ."/" . filtre_nombre(abs($fraction['denominateur'])) . ")";
			}
		}
	}
}

if ( ! function_exists('signe')){
	function signe($nb){
		if($nb['numerateur'] * $nb['denominateur'] >= 0 ) return 1;
		else return -1;
	}
}

if( ! function_exists('fraction_addition')){
	function fraction_addition($a,$b){
		$num = $a['numerateur']*$b['denominateur'] + $b['numerateur']*$a['denominateur'];
		$denom = $a['denominateur']*$b['denominateur'];
		if($num*$denom<0) {
			$num = -abs($num);
			$denom = abs($denom);
		}
		else{
			$num = abs($num);
			$denom = abs($denom);
		}
		return irreductible($num, $denom);
	}
}

if( ! function_exists('fraction_soustraction')){
	function fraction_soustraction($a,$b){
		$num = $a['numerateur']*$b['denominateur'] - $b['numerateur']*$a['denominateur'];
		$denom = $a['denominateur']*$b['denominateur'];
		if($num*$denom<0) {
			$num = -abs($num);
			$denom = abs($denom);
		}
		else{
			$num = abs($num);
			$denom = abs($denom);
		}
		return irreductible($num, $denom);
	}
}

if( ! function_exists('fraction_multiplication')){
	function fraction_multiplication($a,$b){
		$num = $a["numerateur"]*$b['numerateur'];
		$denom = $a['denominateur']*$b['denominateur'];
		if($num*$denom<0) {
			$num = -abs($num);
			$denom = abs($denom);
		}
		else{
			$num = abs($num);
			$denom = abs($denom);
		}
		return irreductible($num, $denom);
	}
}

if( ! function_exists('fraction_division')){
	function fraction_division($a,$b){
		$num = $a["numerateur"]*$b['denominateur'];
		$denom = $a['denominateur']*$b['numerateur'];
		if($num*$denom<0) {
			$num = -abs($num);
			$denom = abs($denom);
		}
		else{
			$num = abs($num);
			$denom = abs($denom);
		}
		return irreductible($num, $denom);
	}
}

if( ! function_exists('compare_fraction')){
	function compare_fraction($a,$b){
		/*
		 * 1 si a > b
		 * 0 si a = b
		 * -1 si a < b
		 */
		$val1 = $a['numerateur'] * $b['denominateur'];
		$val2 = $b['numerateur'] * $a['denominateur'];
		if($val1>$val2) return 1;
		else{
			if($val1==$val2) return 0;
			else return -1;
		}
	}
}

if( ! function_exists('negatif')){
	function negatif($tab){
		$negatif = true;
		foreach ($tab as $value) {
			if(signe($value) == 1) {
				$negatif = false;
				break;
			}
		}
		return $negatif;
	}
}

if( ! function_exists('oppose')){
	function oppose($tab){
		foreach ($tab as $key=>$value) {
			$res[$key] = fraction_soustraction(transformation(0),$value);
		}
		return $res;
	}
}

if ( ! function_exists('denominateur_commun')){
	function denominateur_commun($row){
		$denominateur = 1;
		foreach ($row as $value) {
			$denominateur *= $value['denominateur'];
		}
		return $denominateur;
	}
}

if ( ! function_exists('ppcm_multiple')){
	function ppcm_multiple($row,$i){
		if($i==count($row)-2) return ppcm($row[$i]['denominateur'],$row[$i+1]['denominateur']);
		else return abs(ppcm($row[$i]['denominateur'],ppcm_multiple($row, $i+1)));
	}
}

if ( ! function_exists('pgcd_multiple')){
	function pgcd_multiple($row,$i){
		//var_dump(count($row));
		if($i==count($row)-2) return pgcd($row[$i]['numerateur'], $row[$i+1]['numerateur']);
		else return abs(pgcd($row[$i]['numerateur'],pgcd_multiple($row, ($i+1))));
	}
}

if ( ! function_exists('rm_zero')){
	function rm_zero($row){
		$res = array();
		foreach ($row as $key => $value) {
			if($value['numerateur']!=0) $res[]=$value;
		}
		return $res;
	}
}

if ( ! function_exists('etat_coef_x')){
	function etat_coef_x($coef_x){
		$fraction = true;
		foreach ($coef_x as $value) {
			if($value['denominateur']==1) {
				$fraction = false;
				break;	
			}
		}
		
		$entier = true;
		foreach ($coef_x as $value) {
			if($value['denominateur']!=1) {
				$entier = false;
				break;	
			}
		}
		
		$data['fraction'] = $fraction;
		$data['entier'] = $entier;
		return $data;
	}
}

if ( ! function_exists('filtre_nombre')){
	function filtre_nombre($nombre){
		$nb = "$nombre";
		$longueur = strlen($nb);
		$unite = 1;
		$tmp = array();
		$i = $longueur-1;

		do{
			if((($unite)%3)!=0){
				array_push($tmp,$nb[$i]);$unite++;
			}
			else {
				array_push($tmp,$nb[$i]);array_push($tmp,' ');$unite=1;
			}
			$i--;
		}while($i>=0);

		$res = '';

		for($i=sizeof($tmp)-1;$i>=0;$i--){
			$res = $res.$tmp[$i];
		}
		return $res;
	}
}