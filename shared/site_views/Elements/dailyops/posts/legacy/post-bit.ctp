<div class='post standard-post'>
	<?php echo $this->element("dailyops/posts/post-top",array("dop"=>$dop)); ?>
	<?php 
		
		echo $this->Berrics->postMediaDiv($dop,array("lazy"=>1));
	?>
	<?php echo $this->element("dailyops/posts/post-text",array("dop"=>$dop)); ?>
	<?php echo $this->element("dailyops/posts/post-footer",array("dop"=>$dop)); ?>
</div>

