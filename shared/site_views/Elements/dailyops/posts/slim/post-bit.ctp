<?php 

$lz = true;

if(isset($lazy)) $lz = $lazy;



?>
<div class='post slim-post'>
	<?php echo $this->element("dailyops/posts/post-top",array("dop"=>$dop)); ?>
	<?php 
		
		echo $this->Berrics->postMediaDiv($dop,array("lazy"=>$lz));
	?>
	<?php echo $this->element("dailyops/posts/post-text",array("dop"=>$dop)); ?>
	<?php echo $this->element("dailyops/posts/post-footer",array("dop"=>$dop)); ?>
</div>

