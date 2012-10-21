<script>
var sub_total = <?php echo $order['CanteenOrder']['sub_total']; ?>;
var tax_total = <?php echo $order['CanteenOrder']['tax_total']; ?>;
var tax_rate = <?php echo $order['CanteenOrder']['tax_rate']; ?>;
var shipping_total = <?php echo $order['CanteenOrder']['shipping_total']; ?>;
$(document).ready(function() { 

	$("#RefundAmount").keyup(function() { 

		calcRefund();
		
	});

	$("#RefundIncludeShipping,#RefundIncludeSalesTax").change(function() { 

		calcRefund();
		
	});

	
});

function calcRefund() {

	var val = Number($("#RefundAmount").val());

	if(isNaN(val)) {

		$(this).val("0");
		return;
	}
	
	if(val>sub_total) {

		$(this).val("0");
		
		alert("Cannot Credit More Than The Sub Total");

		$('.amount-to-refund').html("0");
		
	} else {

		var tax = 0;
		var shipping = 0;
		if($("#RefundIncludeSalesTax").attr("checked")) {

			var rate = (tax_rate/100);
			
			tax = Number(val*rate);
			tax = tax.toFixed(2);

			$('.debug').html(tax);

			$("#RefundRefundTax").val(tax);
				
		} else {
		
			$("#RefundRefundTax").val(0);
			
		}

		if($("#RefundIncludeShipping").attr("checked")) {

			shipping = shipping_total;
			
		}
		
		$("#RefundRefundTotal").val(val);
		$('.amount-to-refund').html(Number(val)+Number(tax)+Number(shipping));
		
	}
	
}
</script>
<div class='index form'>
	<h2>Refund Transaction</h2>
	<h3>Currency: <?php echo $order['Currency']['name']; ?></h3>
	<div>
		<strong>Shipping Total: </strong><?php echo $order['CanteenOrder']['shipping_total']; ?> 
		<strong>Tax Total: </strong><?php echo $order['CanteenOrder']['tax_total']; ?> 
		<strong>Sub Total: </strong><?php echo $order['CanteenOrder']['sub_total']; ?> 
		<strong>Grand Total: </strong><?php echo $order['CanteenOrder']['grand_total']; ?> 
	</div>
	<div>
		<fieldset>
			<legend>Enter Details</legend>
			<?php 
				echo $this->Form->create("Refund",array("url"=>$this->request->here));
				
				echo $this->Form->input("include_sales_tax",array("type"=>"checkbox","checked"=>true));
				
				echo $this->Form->input("include_shipping",array("type"=>"checkbox"));
				echo $this->Form->input("amount",array("label"=>"Amount (* Cannot exceed sub total )"));
			?>
			<div  style='color:red; font-weight:bold; font-size:22px;'>
			Refund Total: <span class='amount-to-refund'></span>
			</div>
			<?php 
				echo $this->Form->input("refund_total",array("type"=>"hidden"));
				echo $this->Form->input("transaction_id",array("type"=>"hidden","value"=>$transaction['GatewayTransaction']['id']));
				echo $this->Form->end("Process Refund");
			?>
		</fieldset>
	</div>
	<div style='clear:both;'></div>
</div>
<div class='debug'>

</div>