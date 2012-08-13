<div class='index form'>
	<h2>Canteen Shipping Records</h2>
	<?php echo $this->Form->create("CanteenShippingRecord",array("url"=>$this->here)); ?>
	<fieldset>
		<legend>Add New Shipping Record</legend>
		<?php 
			
			if(isset($this->data['CanteenShippingRecord']['canteen_order_id'])) echo $this->Form->input("canteen_order_id",array("type"=>"text"));
		
			echo $this->Form->input("warehouse_id",array("options"=>$whSelect));
			
			echo $this->Form->input("shipping_status",array("value"=>"pending"));
			
			echo $this->Form->submit("Add Record");
			
		?>
		
	</fieldset>
	
	<?php echo $this->Form->end(); ?>
</div>