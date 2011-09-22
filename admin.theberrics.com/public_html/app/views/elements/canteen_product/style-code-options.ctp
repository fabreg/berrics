<?php
	
	echo $this->Form->input("CanteenProduct.style_code_image",array("type"=>"file"));
	echo $this->Form->submit("Upload image",array("name"=>"data[UploadStyleCodeImage]"));

	echo $this->Form->input("CanteenProduct.style_code");
	echo $this->Form->input("CanteenProduct.style_code_label");
	
	
?>

<?php if(strlen($this->data['CanteenProduct']['style_code_image'])>0): ?>
<div style=''>
	<label>Style Code Image</label>
	<img src='http://img.theberrics.com/i.php?src=/product-img/<?php echo $this->data['CanteenProduct']['style_code_image']; ?>&w=80' />
</div>
<?php endif;?>
	
<?php echo $this->Form->submit("Update Product"); ?>