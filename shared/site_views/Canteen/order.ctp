
<div style='width:728px; float:left;'>
	<?php 
	
		$content = $this->element("canteen/order-status");
		echo $this->element("paper1",array("content"=>$content));
		
	?>
</div>
<div style='float:right; width:300px;'>
	<?php echo $this->element("layout/right-banners"); ?>
</div>
<div style='clear:both;'></div>