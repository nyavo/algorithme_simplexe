<form action="<?php echo base_url("solution")?>" method="post">
<?php 
$a = $nb_variable+1;
for($i=0;$i<$nb_equation;$i++){
	for($j=0;$j<$nb_variable;$j++){
		?>
		<input type="number" name="<?php echo $i.$j?>">x<?php echo $j+1?> +
		
		<?php
	}
	?>
	<input type="hidden" name="<?php echo $i.($a-1)?>" value="1">x<?php echo $a;$a++;?>
	= <input type="number" name="b<?php echo $i?>">
	<?php
	echo '<br><br>';
}?>

<?php echo strtoupper($type)?>(Z = <?php for($i=1;$i<$nb_variable;$i++) {?> <input type="number" name="coef_x<?php echo $i?>">x<?php echo $i?> + <?php }?>
<input type="number" name="coef_x<?php echo $i?>">x<?php echo $i?>)
<input type="hidden" value="<?php echo $nb_variable?>" name="nb_variable">
<input type="hidden" value="<?php echo $nb_equation?>" name="nb_equation">
<input type="hidden" value="<?php echo $type?>" name="type">
<br><br>
<input type="submit" value="resoudre">
</form>