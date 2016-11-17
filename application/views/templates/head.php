<?php
if(!empty($meta))
	foreach($meta as $name=>$content){
		echo "\n\t\t";
?>
<meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" />
<?php
	}
echo "\n";

if(!empty($canonical)){
	echo "\n\t\t";
?>
<link rel="canonical" href="<?php echo $canonical?>" />
<?php
}
echo "\n\t";
foreach($css as $file){
	echo "\n\t\t";
?>
<link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" />
<?php
} 
echo "\n\t";
foreach($js as $file){
	echo "\n\t\t";
?>
<script src="<?php echo $file; ?>"></script>
<?php
} 
echo "\n\t";
?>