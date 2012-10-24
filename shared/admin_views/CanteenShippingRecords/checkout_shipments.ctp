<script>

$(document).ready(function() { 

	$("#CanteenShippingRecordRefNumber").focus();
	$('.progress').hide();
	
	$("#checkout-form").ajaxForm({

		success:function(d) {
			$("#CanteenShippingRecordRefNumber").val('').focus();
	
			$('.results').append(d);

			$('.progress').hide();
			
		},
		beforeSubmit:function() {

			$('.progress').show();

		}
		
	});
	
});
</script>
<style>
.progress {

	text-align:center;
	padding:10px;

}
</style>
<?php 

?>
<div class='index form'>
	
	<fieldset>
		<legend>Scan-out Shipments</legend>
		<?php 
			echo $this->Form->create("CanteenShippingRecord",array("url"=>"/canteen_shipping_records/ajax_checkout_shipments","id"=>"checkout-form"));
		?>
		
		<div style='float:left; margin-right:5px;'>
			<?php 
				echo $this->Form->input("process_inventory",array("type"=>"checkbox","checked"=>"checked"));
				
			?>
		</div>
		<div style='float:left; margin-right:5px;'>
		<?php echo $this->Form->input("send_customer_email",array("type"=>"checkbox","checked"=>"checked")); ?>
		</div>
		
		<?php 
			
			echo $this->Form->input("ref_number");
			echo $this->Form->end("Go");
			
		?>
	</fieldset>
	
	<div class='progress'>
		Searching Shipping Records.......
	</div>
	<div class='results'>
		
	</div>
</div>