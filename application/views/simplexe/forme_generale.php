<form action="<?php echo base_url("solution") ?>" method="post">
<?php
$i = 0;
foreach ($matrice as $key => $array_value) {
	$debut = true;
	foreach ($array_value as $key => $value) {
		?>
<input
	type="hidden" name="<?php echo $i.$key ?>" value="<?php echo $value['numerateur']."/".$value['denominateur']?>">
		<?php
		if(signe($value) < 0){
			if(affichage_fraction($value) == -1){
				if(!$debut) echo " - x".($key+1);
				else {
					echo "- x".($key+1);
					$debut = false;
				}
			}
			else{
				if(!$debut) echo " ". affichage_fraction($value) ." x".($key+1);
				else {
					echo affichage_fraction($value) ." x".($key+1);
					$debut = false;
				}
			}
		}
		else{
			if(affichage_fraction($value)!=0){
				if(affichage_fraction($value) == 1) {

					if(!$debut) echo " + x".($key+1);
					else {
						echo "x".($key+1);
						$debut = false ;
					}
				}
				else{
					if(!$debut) echo " + ". affichage_fraction($value) ." x".($key+1);
					else{
						echo affichage_fraction($value)." x".($key+1);
						$debut = false;
					}
				}
			}
		}
	}
	echo " = " . affichage_expression($b[$i]);
	$i++;
	echo "<br><br>";
}?>

<?php if($type=="min"){
	echo "- MAX ( -Z = ";
	for($i=0;$i<($nb_equation+$nb_variable+$nb_equation_suppl+$nb_variable_artificielle);$i++){
		if($i<$nb_variable)	$coef_x[$i]['numerateur'] = -$coef_x[$i]['numerateur'];
		if($i==0) {
			if(affichage_fraction($coef_x[$i]) == 1){
				echo "- x".($i+1);
			}
			else{
				echo affichage_fraction($coef_x[$i])." x".($i+1);
			}
			?>
			<input type="hidden" name="coef_x<?php echo $i+1 ?>" value="<?php echo $coef_x[$i]['numerateur']. "/" . $coef_x[$i]['denominateur'];?>">
			<?php 
		}
		else {
			if($i<$nb_variable) {
				if(signe($coef_x[$i])>=0) {
					if(affichage_fraction($coef_x[$i]) == 1){
						echo " + x".($i+1);
					}
					else{
						echo " + ".affichage_fraction($coef_x[$i])." x".($i+1);
					}
				}
				else {
					if(affichage_fraction($coef_x[$i]) == -1){
						echo " - x".($i+1);
					}
					else{
						echo " ". affichage_fraction($coef_x[$i])." x".($i+1);
					}
				}
				?>
				<input type="hidden" name="coef_x<?php echo $i+1 ?>" value="<?php echo $coef_x[$i]['numerateur']. "/" . $coef_x[$i]['denominateur'];?>">
				<?php 
			}
			else{
				if($i<$nb_variable+$nb_equation+$nb_equation_suppl){
					echo " + 0 x".($i+1);
					?>
					<input type="hidden" name="coef_x<?php echo $i+1?>" value="0/1">
					<?php 
				}
				else{
					echo " - M x".($i+1);
					?>
					<input type="hidden" name="coef_x<?php echo $i+1 ?>" value="-M">
					<?php
				}
			}
		}
	}
}
else{
	echo "MAX ( Z = ";
	for($i=0;$i<($nb_equation+$nb_variable+$nb_equation_suppl+$nb_variable_artificielle);$i++){
		if($i==0) {
			$str = affichage_fraction($coef_x[$i]);
			if($str == 1) echo "x".($i+1);
			else {
				if($str == -1) echo "- x".($i+1);
				else echo affichage_fraction($coef_x[$i])." x".($i+1);
			}
			?>
			<input type="hidden" name="coef_x<?php echo $i+1 ?>" value="<?php echo $coef_x[$i]['numerateur']."/".$coef_x[$i]['denominateur'];?>">
			<?php 
		}
		else {
			if($i<$nb_variable) {
				if(signe($coef_x[$i])>=0) {
					if(affichage_fraction($coef_x[$i]) == 1) echo " + x".($i+1);
					else echo " + ".affichage_fraction($coef_x[$i])." x".($i+1);
				}
				else {
					if(affichage_fraction($coef_x[$i]) == -1) echo " - x".($i+1);
					else echo " ". affichage_fraction($coef_x[$i])." x".($i+1);
				}
				?>
				<input type="hidden" name="coef_x<?php echo $i+1 ?>" value="<?php echo $coef_x[$i]['numerateur']."/".$coef_x[$i]['denominateur'];?>">
				<?php 
			}
			else{
				if($i<$nb_variable+$nb_equation+$nb_equation_suppl){
					echo " + 0 x".($i+1);
					?>
					<input type="hidden" name="coef_x<?php echo $i+1?>" value="0/1">
					<?php
				}
				else{
					echo " - M x".($i+1);
					?>
					<input type="hidden" name="coef_x<?php echo $i+1 ?>" value="- M">
					<?php
				}
			}
		}
	}
}

echo ")<br><br>";
?>
<?php for($i=0;$i<$nb_equation+$nb_equation_suppl;$i++){
	?>
	<input type="hidden" name="operation<?php echo $i+1?>" value="<?php echo $operation[$i]?>">
	<input type="hidden" name="b_numerique<?php echo $i?>" value="<?php echo $b[$i]["numerique"]["numerateur"] . "/" . $b[$i]["numerique"]["denominateur"]?>">
	<input type="hidden" name="b_litterale<?php echo $i?>" value="<?php echo $b[$i]["litterale"]["numerateur"] . "/" . $b[$i]["litterale"]["denominateur"]?>">
	<?php
}?>

<input type="hidden" name="nb_variable" value="<?php echo $nb_variable?>">
<input type="hidden" name="nb_equation" value="<?php echo $nb_equation?>">
<input type="hidden" name="nb_equation_suppl" value="<?php echo $nb_equation_suppl?>">
<input type="hidden" name="nb_variable_artificielle" value="<?php echo $nb_variable_artificielle?>">
<input type="submit" value="Résoudre">
</form>


