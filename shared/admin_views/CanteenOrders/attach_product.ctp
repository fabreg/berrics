<div class='index form'>
	<h2>Attach Product To Order</h2>
	<?php echo $this->Form->create("CanteenOrderItem",array("url"=>$this->request->here)); ?>
	<fieldset>
		<legend>
			Select an item
		</legend>
		<?php echo $this->Form->input("canteen_product_id",array("options"=>$productDrop))?>
		<?php echo $this->Form->submit("Attach Product"); ?>
	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>