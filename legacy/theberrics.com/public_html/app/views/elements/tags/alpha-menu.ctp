<?php
$alpha = array ("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

?>
<div class='alpha-menu'>
	<?php 
		foreach($alpha as $a):
	?>
		<a href='/tags/<?php echo strtolower($a); ?>'><?php echo strtoupper($a); ?></a>
	<?php 
		endforeach;
	?>
</div>