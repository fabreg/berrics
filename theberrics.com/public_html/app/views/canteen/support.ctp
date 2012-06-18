<div>
	<div style='width:728px; float:left;'>
		<?php 
		
			$support_content = $this->element("canteen/canteen-support");
		
			echo $this->element("paper1",array("content"=>$support_content)); 
			
		?>
	</div>
	<div style='float:right; width:300px;'>
		<?php echo $this->element("layout/right-banners")?>
	</div>
	<div style='clear:both;'></div>
</div>