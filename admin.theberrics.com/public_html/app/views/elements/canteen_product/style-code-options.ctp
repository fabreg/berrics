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
<div>
<h3>Related Styles</h3>
<table cellspacing='0'>
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>-</th>
	</tr>
	<?php foreach($this->data['RelatedStyles'] as $r): ?>
	<tr>
		<td>
		<?php echo $r['CanteenProduct']['id']; ?>
		</td>
		<td>
		<?php echo $r['CanteenProduct']['name']; ?>  - <?php echo $r['CanteenProduct']['sub_title']; ?>
		</td>
		<td class='actions'>
			<a href='/canteen_product/edit/<?php echo $r['CanteenProduct']['id']; ?>'>Edit</a>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
</div>