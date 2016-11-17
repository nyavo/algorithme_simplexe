<div class="row well center">
	<form class="" method="post"
		action="<?php echo base_url('initialisation')?>">

		<!-- <div class="radio"> -->
		<div class="row">
			<div class="span6 right">Type :</div>
			<div class="span6 left">
				<div class="row">
					<label> <input type="radio" name="type" id='min' value='min'
						checked> Minimisation</label>
				</div>
				<br>
				<!--</div>-->
				<!--<div class="radio">-->
				<div class="row">
					<label> <input type="radio" name="type" id='max' value='max'> Maximisation
					</label>
				</div>
			</div>
		</div>
		<br>
		<!--</div>-->
		<div class="row">
			Nombre de variables : <input type="number" name="nb_variable">
		</div>
		<br>
		<div class="row">
			Nombre d'equations : <input type="number" name="nb_equation">
		</div>
		<br>
		<button class="btn btn-primary" type="submit">Initialiser</button>
	</form>
</div>
