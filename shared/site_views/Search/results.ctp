<h1>
Search: <?php echo strtoupper($search_label); ?>
</h1>
<div id='posts' class='results'>
	<?php 
	
		echo $this->element("results/posts-div",array(compact("posts_data","posts_data_total")));
	
	?>
</div>
