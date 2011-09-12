<?php 


	$title_for_layout = "TAG DIRECTORY: ".$this->params['letter'];
	
	foreach($tags as $t) $meta_k .= $t['Tag']['name'].",";

	$this->set(compact("title_for_layout","meta_k"));
	
?>
<div id='tag-index'>
<h1>TAG DIRECTORY: <?php echo strtoupper($this->params['letter']); ?></h1>
<?php

	echo $this->element("tags/alpha-menu");

?>	
	
	<div class='tag-list'>
		<ul>
			<?php 
				foreach($tags as $t):
			?>
				<li><a href='/tags/<?php echo $t['Tag']['slug']; ?>' title='<?php echo strtoupper($t['Tag']['name']); ?>'><?php echo strtoupper($t['Tag']['name']); ?></a></li>
			<?php 
				endforeach;
			?>
		</ul>	
	</div>	
</div>