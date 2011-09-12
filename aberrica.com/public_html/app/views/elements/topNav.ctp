<?php

$cats = $topNav;

?>
<ul>
	<li>
		<?php echo $this->Html->link("MAIN","/"); ?>
	</li>
	<?php 
		foreach($cats as $v):
	?>
	<li>
		<?php echo $this->Html->link(strtoupper($v['AberricaCategory']['name']),"/category/".$v['AberricaCategory']['uri']); ?>
	</li>
	<?php 	
	
		endforeach;
	
	?>
</ul>