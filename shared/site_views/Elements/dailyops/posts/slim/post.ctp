<?php 

$lz = true;

if(isset($lazy)) $lz = $lazy;



?>
<div class='post slim-post'>
	<?php echo $this->element("dailyops/posts/post-top",array("dop"=>$post)); ?>
	<?php 
		
		echo $this->Berrics->postMediaDiv($post,array("lazy"=>$lz));
	?>
	<?php echo $this->element("dailyops/posts/post-text",array("dop"=>$post)); ?>
	<?php echo $this->element("dailyops/posts/post-footer",array("dop"=>$post)); ?>
</div>

