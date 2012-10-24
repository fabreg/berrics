<script>

$(document).ready(function() { 

	$("#CanteenOrderStartDate,#CanteenOrderEndDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	
});

</script>
<style>

.date-ranges {


}

.date-ranges div.text {

	float:left;
	width:25%;
	clear:none;
}

</style>
<div class='form index' style='width:750px; margin:0px;'>
	<h2>Search Orders</h2>	
	<?php echo $this->Form->create("CanteenOrder",array("url"=>$this->request->here)); ?>
	<fieldset>
		<legend>Order Information</legend>
		<?php 
			
			echo $this->Form->input("CanteenOrder.order_status",array("options"=>$orderStatus,"empty"=>true));
			
		?>
		
		<div class='date-ranges'>
		<?php 
			echo $this->Form->input("CanteenOrder.start_date",array("type"=>"text"));
			echo $this->Form->input("CanteenOrder.end_date",array("type"=>"text"));
		?>	
			<div style='clear:both;'></div>
		</div>
		<?php 
			echo $this->Form->input("CanteenOrder.id",array("type"=>"text","label"=>"Order ID"));
			echo $this->Form->input("UserAddress.email",array("label"=>"Email (*this will search address type 'shipping' records)"));
			echo $this->Form->submit("Search");
		?>
	</fieldset>
	<fieldset>
		<legend>Customer Information</legend>
		<?php 
			echo $this->Form->input("UserAddress.address_type",array("options"=>array("shipping"=>"SHIPPING","billing"=>"BILLING"),"empty"=>true,"label"=>"Address Type (*Must select an address type to search customer info)"));
			echo $this->Form->input("UserAddress.first_name");
			echo $this->Form->input("UserAddress.last_name");
			echo $this->Form->input("UserAddress.street");
			echo $this->Form->input("UserAddress.apt");
			echo $this->Form->input("UserAddress.city");
			echo $this->Form->input("UserAddress.state");
			echo $this->Form->input("UserAddress.postal_code");
			echo $this->Form->input("UserAddress.country_code",array("options"=>Arr::countries(),"empty"=>true));
		?>
	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>