<script>
$(document).ready(function() { 

	$("#CanteenOrderDateStart,#CanteenOrderDateEnd").datepicker({
		"dateFormat":"yy-mm-dd"
	});


	
});

</script>
<div class='index form'>
<fieldset>
	<legend>Search Canteen Orders</legend>
	<div style='font-style:italic;'>
		Use "%" (without quotes) as a wildcard.
	</div>
	<?php 
	
		echo $this->Form->create("CanteenOrder");
		echo $this->Form->input("order_status",array("options"=>$orderStatusMenu,"empty"=>true));
		echo $this->Form->input("shipping_status",array("options"=>$shippingStatusMenu,"empty"=>true));
		echo $this->Form->input("wh_status",array("options"=>$whStatusMenu,"empty"=>true));
		echo $this->Form->input("email");
	?>
	<div>
		<label>Order ID:</label>
		<input type='text' value='' name='data[CanteenOrder][id1]' id='id1' class='order-id' />-
		<input type='text' value='' name='data[CanteenOrder][id2]' id='id2' class='order-id' />-
		<input type='text' value='' name='data[CanteenOrder][id3]' id='id3' class='order-id' />-
		<input type='text' value='' name='data[CanteenOrder][id4]' id='id4' class='order-id' />
	</div>
	<?php 
		echo $this->Form->input("date_start");
		echo $this->Form->input("date_end");
		echo $this->Form->input("first_name");
		echo $this->Form->input("last_name");
		echo $this->Form->input("street_address");
		echo $this->Form->input("apt");
		echo $this->Form->input("country",array("options"=>Arr::countries(),"empty"=>true));
		echo $this->Form->input("state");
		echo $this->Form->input("city");
		echo $this->Form->input("postal");
		echo $this->Form->end("Search");
	?>
</fieldset>	

</div>