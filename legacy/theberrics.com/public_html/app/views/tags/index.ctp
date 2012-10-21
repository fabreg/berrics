<?php 


$this->Html->css(array("result-elements"),"stylesheet",array("inline"=>false));

$this->Html->script(array("results"),array("inline"=>false));

?>
<script>

var tag_id = <?php echo $tag['Tag']['id']; ?>;


</script>
<div id='tag'>
	<h1>
		<?php echo strtoupper($tag['Tag']['name']); ?>
	</h1>
	
	<hr />
	
	<div id='posts'>
		<?php 
			if($posts_data_total>0) {
				
				echo $this->element("results/posts-div",array("posts_data"=>$posts_data,"posts_data_total"=>$posts_data_total));
				
			}
		?>
	</div>
</div>
