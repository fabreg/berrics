<script>
$(document).ready(function() { 



	
});
</script>
<div class='index form'>
	<h2>Refund Transaction</h2>
	<h3>Currency: <?php echo $order['Currency']['name']; ?></h3>
	<div style='width:33%; float:left;'>
		<fieldset>
			<legend>Amount To Refund</legend>
		</fielsdet>
	</div>
	<div style='width:33%; float:left;'>
		<fieldset>
			<legend>Confirm Refund</legend>
		</fieldset>
	</div>
	<div style='width:33%; float:left;'>
		<fieldset>
			<legend>Original Totals</legend>
			<table cellspacing='0'>
				<tr>
					<td align='right' width='20%'>Tax Total</td>
					<td><?php echo $order['CanteenOrder']['tax_total']; ?></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div style='clear:both;'></div>
</div>
<?php 

pr($transaction);

pr($order);

?>