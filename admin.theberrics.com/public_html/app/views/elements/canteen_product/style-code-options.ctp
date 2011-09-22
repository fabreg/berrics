<?php
	echo $this->Form->input("CanteenProduct.style_code_image",array("type"=>"file"));
	echo $this->Form->submit("Upload image");
	echo $this->Form->input("CanteenProduct.style_code");
	echo $this->Form->input("CanteenProduct.style_code_label");
	echo $this->Form->submit("Update Product");
	
?>