<table>
	<tr>
		<td>Coefficient dans Z</td>
		<td></td>
		<?php foreach($coef_dans_z as $key=>$value){
		?>
			<td><?php echo $value?></td>
		<?php 
		}?>
		<td></td>
	</tr>
	<tr>
		<td>Base</td>
		<td></td>
		<?php for($i=0;$i<$nb_equation+$nb_variable;$i++){
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
				<td><?php echo $var_coef_base[$i]['coef']?></td>
				<td><?php echo $var_coef_base[$i]['libelle']?></td>
		<?php 
		for($j=0;$j<$nb_equation+$nb_variable;$j++){
			?>
				<td><?php echo $matrice[$i][$j]?></td>
			
			<?php 
		}
		?>
			<td><?php echo $b[$i]?></td>
		</tr>
		<?php 
	}?>
	<tr>
		<td>Zj</td>
		<td></td>
		<?php foreach($ZJ as $key=>$value){
			?>
			<td><?php echo $value?></td>
			<?php
		}?>
		<td>Z = <?php echo $Z?></td>
	</tr>
	<tr>
		<td>Delta J</td>
		<td></td>
		<?php foreach ($delta_J as $key => $value) {
			?>
			<td><?php echo $value?></td>
			<?php
		}?>
	</tr>
</table>
<form action="<?php echo base_url('solution/resolution')?>" method="post">
	<input type="submit" value="suivant">
	<?php for($i=0;$i<$nb_equation;$i++){
		for($j=0;$j<$nb_equation+$nb_variable;$j++){
			?>
			<input type="hidden" name="<?php echo $i.$j?>" value="<?php echo $matrice[$i][$j]?>">
			<?php 
		}
		?>
		<input type="hidden" name="b<?php echo $i?>" value="<?php echo $b[$i]?>">
		<input type="hidden" name="lib_coef_z<?php echo $i?>" value="<?php echo $var_coef_base[$i]['libelle']?>">
		<input type="hidden" name="var_coef_base<?php echo $i?>" value="<?php echo $var_coef_base[$i]['coef']?>"><br><br>
		<?php
	}?>
	<?php for($i=0;$i<$nb_equation+$nb_variable;$i++) {
		?>
		<input type="hidden" name="coef_dans_z<?php echo $i?>" value="<?php echo $coef_dans_z[$i]?>">
		<input type="hidden" name="ZJ<?php echo $i?>" value="<?php echo $ZJ[$i]?>">
		<input type="hidden" name="DJ<?php echo $i?>" value="<?php echo $delta_J[$i]?>">
		<?php 
	}?>
	<input type="hidden" name="nb_variable" value="<?php echo $nb_variable?>">
	<input type="hidden" name="nb_equation" value="<?php echo $nb_equation?>">
	<input type="hidden" name="type" value="<?php echo $type?>">
</form>