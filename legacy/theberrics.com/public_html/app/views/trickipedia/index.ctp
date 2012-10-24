<?php


$this->Html->script(array("dailyops/post-bit"),array("inline"=>false));

?>

<?php 

	foreach($posts as $post) {
		
		echo $this->element("dailyops/post-bit",array("dop"=>$post));
		
	}

?>