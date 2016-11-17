<table border="1" cellspacing="0" cellpadding="10">
	<tr>
		<td colspan="2" style="text-align:center;">Coefficient dans Z</td>
		
		<?php foreach($coef_dans_z as $key=>$value){
		?>
			<td><?php echo affichage_expression($value)?></td>
		<?php 
		}?>
		<td></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">Base</td>
		<?php for($i=0;$i<$nb_equation+$nb_variable+$nb_variable_artificielle;$i++){
		?>
		<td>x<?php echo $i+1?></td>
		<?php
		}?>
		<td>bi</td>
	</tr>
	<tr>
		<td>Coef. Z</td>
		<td>Var. base</td>
	</tr>
	<?php for($i=0;$i<$nb_equation;$i++){
		?>
		<tr>
				<td><?php echo affichage_expression($var_coef_base[$i])?></td>
				<td><?php echo $var_coef_base[$i]['libelle']?></td>
		<?php 
		for($j=0;$j<$nb_equation+$nb_variable+$nb_variable_artificielle;$j++){
			?>
				<td><?php echo $matrice[$i][$j]?></td>
			
			<?php 
		}
		?>
			<td><?php echo affichage_expression_eps($b[$i])?></td>
		</tr>
		<?php 
	}?>
	<tr>
		<td colspan="2" style="text-align:center;">Zj</td>
		<?php foreach($ZJ as $key=>$value){
			?>
			<td><?php echo affichage_expression($value)?></td>
			<?php
		}?>
		<td rowspan="2">Z = <?php echo affichage_expression($Z)?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">Delta J</td>
		<?php foreach ($delta_J as $key => $value) {
			?>
			<td><?php echo affichage_expression($value)?></td>
			<?php
		}?>
	</tr>
</table>
<form action="<?php echo base_url('solution/resolution')?>" method="post">
	<input type="submit" value="suivant">
	<?php for($i=0;$i<$nb_equation;$i++){
		for($j=0;$j<$nb_equation+$nb_variable+$nb_variable_artificielle;$j++){
			?>
			<input type="hidden" name="<?php echo $i.$j?>" value="<?php echo $matrice[$i][$j]?>">
			<?php 
		}
		?>
		<input type="hidden" name="b_numerique<?php echo $i?>" value="<?php echo $b[$i]['numerique']?>">
		<input type="hidden" name="b_litterale<?php echo $i?>" value="<?php echo $b[$i]['litterale']?>">
		<input type="hidden" name="indice<?php echo $i?>" value="<?php echo $var_coef_base[$i]['indice']?>">
		<input type="hidden" name="lib_coef_z<?php echo $i?>" value="<?php echo $var_coef_base[$i]['libelle']?>">
		<input type="hidden" name="var_coef_base_numerique<?php echo $i?>" value="<?php echo $var_coef_base[$i]['numerique']?>">
		<input type="hidden" name="var_coef_base_litterale<?php echo $i?>" value="<?php echo $var_coef_base[$i]['litterale']?>"><br><br>
		<?php
	}?>
	<?php for($i=0;$i<$nb_equation+$nb_variable+$nb_variable_artificielle;$i++) {
		?>
		<input type="hidden" name="coef_dans_z_numerique<?php echo $i?>" value="<?php echo $coef_dans_z[$i]["numerique"]?>">
		<input type="hidden" name="coef_dans_z_litterale<?php echo $i?>" value="<?php echo $coef_dans_z[$i]["litterale"]?>">
		<input type="hidden" name="ZJ_numerique<?php echo $i?>" value="<?php echo $ZJ[$i]["numerique"]?>">
		<input type="hidden" name="ZJ_litterale<?php echo $i?>" value="<?php echo $ZJ[$i]["litterale"]?>">
		<input type="hidden" name="DJ_numerique<?php echo $i?>" value="<?php echo $delta_J[$i]["numerique"]?>">
		<input type="hidden" name="DJ_litterale<?php echo $i?>" value="<?php echo $delta_J[$i]["litterale"]?>">
		<?php 
	}?>
	<input type="hidden" name="nb_variable" value="<?php echo $nb_variable?>">
	<input type="hidden" name="nb_equation" value="<?php echo $nb_equation?>">
	<input type="hidden" name="nb_variable_artificielle" value="<?php echo $nb_variable_artificielle?>">
	<input type="hidden" name="type" value="<?php echo $type?>">
</form>