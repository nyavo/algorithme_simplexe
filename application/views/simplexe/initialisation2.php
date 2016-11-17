<form action="<?php echo base_url("initialisation/generalisation") ?>" method="post">
    <?php
    $a = $nb_variable + 1;
    for ($i = 0; $i < $nb_equation; $i++) {
        for ($j = 0; $j < $nb_variable - 1 ; $j++) {
            ?>
            <input type="number" name="<?php echo $i . $j ?>" class="form-control">x<?php echo $j + 1 ?> +
        <?php
        }
        ?>
        <input type="number" class="form-control" name="<?php echo $i . $j ?>">x<?php echo $j + 1 ?>
        <select name="operation<?php echo $i+1?>">
        	<option value="inf">≤</option>
        	<option value="sup">≥</option>
        	<option value="egal">=</option>
        </select>
         <input class="form-control" type="number" name="b_numerique<?php echo $i ?>">
        <?php
        echo '<br><br>';
    }?>

    <?php echo strtoupper($type) ?>(Z = <?php for ($i = 1; $i < $nb_variable; $i++) { ?> <input type="number" class="form-control" 
                                                                                                name="coef_x<?php echo $i ?>">x<?php echo $i ?> + <?php } ?>
    <input type="number" class="form-control" name="coef_x<?php echo $i ?>">x<?php echo $i ?>)
    <input type="hidden" value="<?php echo $nb_variable ?>" name="nb_variable">
    <input type="hidden" value="<?php echo $nb_equation ?>" name="nb_equation">
    <input type="hidden" value="<?php echo $type ?>" name="type">
    <br><br>
    <input type="submit" value="Forme Standard">
</form>