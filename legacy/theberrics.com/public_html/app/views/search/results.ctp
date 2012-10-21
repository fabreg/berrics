<?php 


$this->Html->css(array("result-elements"),"stylesheet",array("inline"=>false));
$this->Html->script(array("results"),array("inline"=>false));


?>
<div id='posts'>
	<?php 
	
		echo $this->element("results/posts-div",array(compact("posts_data","posts_data_total")));
	
	?>
</div>
