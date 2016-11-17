<div class="row well center">
<table border="1" cellspacing="0" cellpadding="10" class="table">
	<tr>
		<th colspan="2" style="text-align:center;"><h3>Coefficient dans Z</h3></th>
		
		<?php foreach($coef_dans_z as $key=>$value){
		?>
			<th style="font-size: 18px"><?php echo affichage_expression($value)?></th>
		<?php 
		}?>
		
	</tr>
	<tr>
		<th colspan="2" style="text-align:center;"><h3>Base</h3></th>
		<?php for($i=0;$i<$nb_equation+$nb_variable+$nb_variable_artificielle;$i++){
		?>
		<td><h3>x<sub><?php echo $i+1?></sub></h3></td>
		<?php
		}?>
		<th><h3>b<sub>i</sub></h3></th>
		<?php if(!isset($ok)){?><th><h3>b<sub>i</sub>/x<sub>ij</sub></h3></th><?php }?>
	</tr>
	<tr>
		<th><h3>Coef. Z</h3></th>
		<th><h3>Var. base</h3></th>
	</tr>
	<?php for($i=0;$i<$nb_equation;$i++){
		?>
		<tr>
				<td><?php echo affichage_expression($var_coef_base[$i])?></td>
				<th><h3><?php echo $var_coef_base[$i]['libelle']?></h3></th>
		<?php 
		for($j=0;$j<$nb_equation+$nb_variable+$nb_variable_artificielle;$j++){
			?>
				<td 
				<?php 
					echo ($i==$pivot['ligne'])&&($j==$pivot['colonne']&&!isset($ok)) ? 'class="pivot"' : '';
				?>> <?php echo affichage_fraction($matrice[$i][$j])?></td>
			
			<?php 
		}
		?>
			<td><?php echo affichage_expression_eps($b[$i])?></td>
			<?php if(!isset($ok)){?><td <?php 
					echo ($i==$pivot['ligne']) ? 'class="composant_pivot"' : '';
				?>><?php if($rapport[$i]['numerique']['numerateur']==0 && $rapport[$i]['litterale']['numerateur'] == 0) echo "-";
			else echo affichage_expression_eps($rapport[$i])?></td><?php }?>
		</tr>
		<?php 
	}?>
	<tr>
		<td colspan="2" style="text-align:center;"><h3>Zj</h3></td>
		<?php foreach($ZJ as $key=>$value){
			?>
			<td><?php echo affichage_expression($value)?></td>
			<?php
		}?>
		<td rowspan="2"><h3>Z = <?php echo affichage_expression($Z)?></h3></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;"><h3>Delta J</h3></td>
		<?php $i=0;foreach ($delta_J as $key => $value) {
			?>
			<td <?php 
					echo ($i==$pivot['colonne']&&!isset($ok)) ? 'class="composant_pivot"' : '';
				?>><?php echo affichage_expression($value);$i++;?></td>
			<?php
		}?>
	</tr>
</table>
<form action="<?php echo base_url('solution/resolution')?>" method="post">
	<?php if(!isset($ok)){?><button class="btn btn-primary" type="submit">Suivant</button><?php }?>
	<?php for($i=0;$i<$nb_equation;$i++){
		for($j=0;$j<$nb_equation+$nb_variable+$nb_variable_artificielle;$j++){
			?>
			<input type="hidden" name="<?php echo $i.$j?>" value="<?php echo $matrice[$i][$j]['numerateur'].'/'.$matrice[$i][$j]['denominateur']?>">
			<?php 
		}
		?>
		<input type="hidden" name="b_numerique<?php echo $i?>" value="<?php echo $b[$i]['numerique']['numerateur'].'/'.$b[$i]['numerique']['denominateur']?>">
		<input type="hidden" name="b_litterale<?php echo $i?>" value="<?php echo $b[$i]['litterale']['numerateur'].'/'.$b[$i]['litterale']['denominateur']?>">
		<input type="hidden" name="indice<?php echo $i?>" value="<?php echo $var_coef_base[$i]['indice']?>">
		<input type="hidden" name="lib_coef_z<?php echo $i?>" value="<?php echo $var_coef_base[$i]['libelle']?>">
		<input type="hidden" name="var_coef_base_numerique<?php echo $i?>" value="<?php echo $var_coef_base[$i]['numerique']['numerateur'].'/'.$var_coef_base[$i]['numerique']['denominateur']?>">
		<input type="hidden" name="var_coef_base_litterale<?php echo $i?>" value="<?php echo $var_coef_base[$i]['litterale']['numerateur'].'/'.$var_coef_base[$i]['litterale']['denominateur']?>">
		<?php
	}?>
	<?php for($i=0;$i<$nb_equation+$nb_variable+$nb_variable_artificielle;$i++) {
		?>
		<input type="hidden" name="coef_dans_z_numerique<?php echo $i?>" value="<?php echo $coef_dans_z[$i]["numerique"]['numerateur'].'/'.$coef_dans_z[$i]["numerique"]['denominateur']?>">
		<input type="hidden" name="coef_dans_z_litterale<?php echo $i?>" value="<?php echo $coef_dans_z[$i]["litterale"]['numerateur'].'/'.$coef_dans_z[$i]["litterale"]['denominateur']?>">
		<input type="hidden" name="ZJ_numerique<?php echo $i?>" value="<?php echo $ZJ[$i]["numerique"]['numerateur'].'/'.$ZJ[$i]["numerique"]['denominateur']?>">
		<input type="hidden" name="ZJ_litterale<?php echo $i?>" value="<?php echo $ZJ[$i]["litterale"]['numerateur'].'/'.$ZJ[$i]["litterale"]['denominateur']?>">
		<input type="hidden" name="DJ_numerique<?php echo $i?>" value="<?php echo $delta_J[$i]["numerique"]['numerateur'].'/'.$delta_J[$i]["numerique"]['denominateur']?>">
		<input type="hidden" name="DJ_litterale<?php echo $i?>" value="<?php echo $delta_J[$i]["litterale"]['numerateur'].'/'.$delta_J[$i]["litterale"]['denominateur']?>">
		<?php 
	}?>
	<input type="hidden" name="nb_variable" value="<?php echo $nb_variable?>">
	<input type="hidden" name="nb_equation" value="<?php echo $nb_equation?>">
	<input type="hidden" name="nb_variable_artificielle" value="<?php echo $nb_variable_artificielle?>">
	<input type="hidden" name="type" value="<?php echo $type?>">
	<input type="hidden" name="multiplicateur" value="<?php echo $multiplicateur['numerateur'].'/'.$multiplicateur['denominateur']?>">
</form>
</div>

<div class="row well center" <?php if(!isset($ok)) echo "style='display:none'"?>>
<?php if(isset($ok) && $ok==true){?>
	<h1>Solution</h1><br>
	<?php for($i=0;$i<$nb_variable;$i++){?>
	<div class="row"><h3>x<sub><?php echo $i+1;?></sub> = <?php echo affichage_expression($resultat[$i])?></h3></div>
<?php }
?><br>
<div class="row"><h3>Z = <?php {
	//var_dump($multiplicateur);
	//echo '---';*/
	if($type == "min") {
		$Z["numerique"]['numerateur'] = abs($Z["numerique"]['numerateur']);
		$Z["numerique"]['denominateur'] = abs($Z["numerique"]['denominateur']);
		$Z["litterale"]['numerateur'] = abs($Z["litterale"]['numerateur']);
		$Z["litterale"]['denominateur'] = abs($Z["litterale"]['denominateur']);
	}
	//var_dump($Z);
	$Z_final["numerique"] = fraction_multiplication($Z["numerique"],$multiplicateur);
	$Z_final['litterale'] = fraction_multiplication($Z['litterale'],$multiplicateur);
	if(($multiplicateur['numerateur']!=1 && $multiplicateur['denominateur']==1)||($multiplicateur['numerateur']==1 && $multiplicateur['denominateur']!=1)||($multiplicateur['numerateur']!=1 && $multiplicateur['denominateur']!=1)) echo affichage_expression($Z) . ' * ' . affichage_fraction($multiplicateur) . " = ";
	echo affichage_expression($Z_final) . '</h3></div>';
	}
}
elseif(isset($pas_de_solution) && $pas_de_solution==true){
	?> 
	<h1>Pas de solution : Contraintes incompatibles</h1>
	<?php 
}?>
<a class="btn btn-primary" href="<?php echo base_url()?>" >Nouveau calcul</a>
</div>
</div>