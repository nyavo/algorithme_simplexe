<form method="post" action="<?php echo base_url('initialisation')?>">
	Type : <input type="radio" name="type" id='min' value='min' checked>Minimisation
	<input type="radio" name="type" id='max' value='max'>Maximisation
	<br>
	<br>
	Nombre de variables : <input type="number" name="nb_variable"><br><br>
	Nombre d'equations : <input type="number" name="nb_equation"><br>
	<input type="submit" value="ok">
</form>
