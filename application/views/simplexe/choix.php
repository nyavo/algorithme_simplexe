<div class="row well center">
	<form class="" method="post"
		action="<?php echo base_url('initialisation')?>">
		<input type="radio" name="type" id='min' value='min' checked>
		Minimisation <input type="radio" name="type" id='max' value='max'>
		Maximisation <br> <br> Nombre de variables : <input type="number"
			name="nb_variable"><br>
		<br> Nombre d'equations : <input type="number" name="nb_equation"><br>
		<button class="btn btn-primary" type="submit">Initialiser</button>
	</form>
</div>
