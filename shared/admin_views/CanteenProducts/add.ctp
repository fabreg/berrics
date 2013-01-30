<?php


?>
<div class='form'>
	<?php echo $this->Form->create("CanteenProduct"); ?>
	<fieldset>
		<legend>General Info</legend>
		<?php echo $this->element("canteen_product/general-info"); ?>
	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>