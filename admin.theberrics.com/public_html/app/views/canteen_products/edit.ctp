<div class='form index'>
<h2>Editing Product ID: <?php echo $this->data['CanteenProduct']['id']; ?></h2>
<?php 
	echo $this->Form->create("CanteenProduct",array("enctype"=>"multipart/form-data","id"=>"CanteenProductEditForm"));
	echo $this->Form->input("id");
?>
<div style='float:left; width:48%;'>
	<fieldset>
		<legend>General Info</legend>
		<?php echo $this->element("canteen_product/general-info"); ?>
	</fieldset>
	<fieldset>
		<legend>Images</legend>
		<?php echo $this->element("canteen_product/images"); ?>
	</fieldset>
</div>
<div style='float:right; width:48%;'>
	<fieldset>
		<legend>Pricing</legend>
		<?php 
			echo $this->element("canteen_product/pricing");
		?>
	</fieldset>
	<fieldset>
		<legend>Style Code Options</legend>
		<?php echo $this->element("canteen_product/style-code-options")?>
	</fieldset>
	<fieldset>
		<legend>Options & Quantities</legend>
		<?php echo $this->element("canteen_product/qty-options"); ?>
	</fieldset>
	<fieldset>
		<legend>Meta Data</legend>
		<?php echo $this->element("canteen_product/meta-data"); ?>
	</fieldset>
	<fieldset>
		<legend>Warehouse Info</legend>
		<?php echo $this->element("canteen_product/wh-info"); ?>
	</fieldset>
</div>
<div style='clear:both;'></div>
<?php 
	echo $this->Form->end();
?>
</div>