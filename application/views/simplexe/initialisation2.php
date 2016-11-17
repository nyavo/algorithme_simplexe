<div class="row well center">
<form action="<?php echo base_url("initialisation/generalisation") ?>" method="post">
    <?php
    $a = $nb_variable + 1;
    for ($i = 0; $i < $nb_equation; $i++) {
        for ($j = 0; $j < $nb_variable - 1 ; $j++) {
            ?>
            <input type="text" name="<?php echo $i . $j ?>" class="form-control" class="number">x<?php echo $j + 1 ?> +
        <?php
        }
        ?>
        <input type="text" class="form-control" name="<?php echo $i . $j ?>" class="isa">x<?php echo $j + 1 ?>
        <select name="operation<?php echo $i+1?>">
        	<option value="inf">≤</option>
        	<option value="sup">≥</option>
        	<option value="egal">=</option>
        </select>
         <input class="form-control" type="text" name="b_numerique<?php echo $i ?>" class="isa">
        <?php
        echo '<br><br>';
    }?>

    <?php echo strtoupper($type) ?>(Z = <?php for ($i = 1; $i < $nb_variable; $i++) { ?> <input type="text" class="form-control" 
                                                                                                name="coef_x<?php echo $i ?>">x<?php echo $i ?> + <?php } ?>
    <input type="text" class="form-control" name="coef_x<?php echo $i ?>" class="isa">x<?php echo $i ?>)
    <input type="hidden" value="<?php echo $nb_variable ?>" name="nb_variable" id="nb_variable">
    <input type="hidden" value="<?php echo $nb_equation ?>" name="nb_equation" id="nb_equation">
    <input type="hidden" value="<?php echo $type ?>" name="type">
    <br><br>
    <button type="submit" class="btn btn-primary" id="submit">Forme Standard</button>
</form>
</div>