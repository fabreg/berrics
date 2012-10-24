<?php 

$user_locale = 'en_us';

$this->set(compact("user_locale"));

//lets build the transaction menus
$charges = Set::extract("/GatewayTransaction[method=/charge|capture/i][approved=1]",$this->data);

$charge_list = array();

foreach($charges as $c) $charge_list[$c['GatewayTransaction']['id']] = $c['GatewayTransaction']['method']." ".$c['GatewayTransaction']['amount']; 

$accs = Set::extract("/User/UserBillingProfile",$this->data);

$acc_list = array();

foreach($accs as $a) $acc_list[$a['UserBillingProfile']['id']] = $a['UserBillingProfile']['name'];


//get the transactions totals
$trans_totals = array();

foreach($this->data['GatewayTransaction'] as $t) if($t['approved'] == 1) @$trans_totals[$t['method']] += $t['amount'];

$line_totals = array();

foreach($this->data['CanteenOrderItem'] as $i) {
	
	@$line_totals['tax_total'] += $i['sales_tax'];
	@$line_totals['price_total'] += $i['price'];
	
}


?>
<style>
.line-item-product img {

	float:left;
	padding-right:5px;

}
.customer-info label {

	float:left;
	clear:none;
	width:30%;
	display:block;
	font-size:12px;

}

.customer-info div.text,.customer-info div.select {
	
	padding:10px;
	font-size:12px;
	height:30px;
	margin:0px;
	padding:2px;
}

.customer-info div.text input {

	width:60%;
	clear:none;
	float:left;
	font-size:12px;
	height:18px;
	padding:0px;
	margin-top:3px;
}

#billing-form div:nth-child(odd),#shipping-form div:nth-child(odd) {

	background-color:#ccc;

}

#billing-form,#shipping-form {

	background-color:#f0f0f0;
	border:1px solid #999;

}

.order-actions div.submit {

	float:left;
	margin:1px;
}
.line-items label {

	float:left;
	display:block;
	clear:none;
	width:130px;
	text-align:right;
	
}

.line-items div.text {

	width:300px;
	margin:auto;
	
}

.line-items div.text input {

	padding:1px;
	font-size:11px;
	width:100px;
	float:left;
	
}

.order-actions {

clear:both;

}

#content .func-link {

	font-weight:800;
	color:green;
}

#credit-forms {

	

}

#credit-debit-forms div.text input {

	font-size:12px;
	height:14px;
	
}

#credit-debit-forms label {

	font-size:12px;

}

#debit-form {

}

#credit-form {

}

</style>
<script>
var order_json = <?php echo json_encode($this->data); ?>;
$(document).ready(function() { 

	
	$("a[func]").click(function() { submitFunction(this); return false; });


	$("#credit-form input").keyup(function() { calcCredit(); });

	$("#credit-debit-forms input[type=text]").blur(function() { 
	
		$(this).val(formatCurrency($(this).val()));
		
	}).blur();
	
});

function formatCurrency(num) {
    num = isNaN(num) || num === '' || num === null ? 0.00 : num;
    return parseFloat(num).toFixed(2);
}

function calcCredit() {

	var tax_total = $("#CanteenOrderTaxTotalCredit").val();
	var sub_total = $("#CanteenOrderSubTotalCredit").val();
	var ship_total = $("#CanteenOrderShippingTotalCredit").val();

	$("#total-credit-div").html(formatCurrency(Number(tax_total)+Number(sub_total)+Number(ship_total)));
	
	
}

function submitFunction(anchor) {

	var func = $(anchor).attr("func");
	var extra = $(anchor).attr("extra");
	var conf = $(anchor).attr('confirm');
	var chk = true;
	if(conf.length>0) {

		chk = confirm(conf);
		
	}

	if(chk) {

		$("#edit-form").append("<input type='hidden' name='data["+func+"]["+extra+"]' />").submit();
		
	}

}




</script>
<div class='index form'>

	
	<?php 
		echo $this->Form->create("CanteenOrder",array("url"=>$this->here,"id"=>"edit-form"));
		echo $this->Form->input("CanteenOrder.id");
	?>	
	
	<div>
		<div style='margin:auto; width:99%;'>
		<div>
			<h1>Edit Order</h1>
			<a href='<?php echo $this->here; ?>'>Refresh Order</a> | <a href='<?php echo (isset($this->params['pass'][1])) ? base64_decode($this->params['pass'][1]):'/canteen_orders/'; ?>'>Back to order manager</a>
			 | <a href='/canteen_orders/print_invoice/<?php echo $this->data['CanteenOrder']['id']; ?>' target='_blank'>Print Packing List</a> | 
			<?php 
								
								switch(strtoupper($this->data['CanteenOrder']['order_status'])) {
									
									case "AUTHORIZED":
										
										echo "<a extra='' func='CaptureOrder' class='func-link' confirm='' href='#'>Capture Order</a> | ";
										//echo $this->Form->submit("Capture and Approve Order",array("name"=>"data[CaptureOrder][{$this->data['CanteenOrder']['id']}]"));
									break;
								}
								
								
								echo "<a extra='' func='CancelOrder' class='func-link' confirm='Are you sure you want to cancel this order?' href='#'>Cancel Order</a> | ";
								
							
								//echo $this->Form->submit("Cancel Order",array("name"=>"data[CancelOrder][{$this->data['CanteenOrder']['id']}]"));
								
								
							?>
		</div>

							
					

		<fieldset style='float:left; width:45%'>
			<legend>Order Info</legend>
				<div >
				<table cellspacing='0'>
					<tr>
						<td width='30%'>Order ID:</td>
						<td><?php echo strtoupper($this->data['CanteenOrder']['id']); ?></td>
					</tr>
					<tr>
						<td width='30%'>Created/Modified:</td>
						<td><?php echo $this->Time->niceShort($this->data['CanteenOrder']['created']); ?>/<?php echo $this->Time->niceShort($this->data['CanteenOrder']['modified']); ?></td>
					</tr>
					<tr>
						<td width='30%'>Order Status:</td>
						<td><?php echo strtoupper($this->data['CanteenOrder']['order_status']); ?></td>
					</tr>
					<tr>
						<td>Warehouse Status:</td>
						<td><?php echo strtoupper($this->data['CanteenOrder']['wh_status']); ?></td>
					</tr>
					<tr>
						<td>Shipping Status:</td>
						<td><?php echo strtoupper($this->data['CanteenOrder']['shipping_status']); ?></td>
					</tr>
					<tr>
						<td>Shipping Carrier:</td>
						<td><?php echo strtoupper($this->data['CanteenOrder']['shipping_carrier']); ?></td>
					</tr>
					<tr>
						<td>Shipping Carrier Tracking:</td>
						<td><?php echo strtoupper($this->data['CanteenOrder']['shipping_carrier_tracking']); ?></td>
					</tr>
					<tr>
						<td>GEO IP Country:</td>
						<td><?php echo strtoupper($this->data['CanteenOrder']['geoip_country_code']); ?> (<?php echo strtoupper($this->data['CanteenOrder']['ip_address']); ?>)</td>
					</tr>
					
					<tr>
						<td>Currency:</td>
						<td>
						
							<?php echo $this->data['Currency']['name']; ?> (<?php echo $this->data['Currency']['id']; ?>)
							<?php 
								if($this->data['Currency']['id'] != "USD") {
									
									echo "".$this->data['Currency']['rate']." VS. USD ";
									
								}
							?>
						</td>
					</tr>
					<tr>
						<td>Sub-Total:</td>
						<td><?php echo $this->Form->text("CanteenOrder.sub_total"); ?> (<?php echo $this->data['CanteenOrder']['currency_id']; ?>) </td>
					</tr>
					<tr>
						<td>Tax Total:</td>
						<td><?php echo $this->Form->text("CanteenOrder.tax_total"); ?> (<?php echo $this->data['CanteenOrder']['currency_id']; ?>)</td>
					</tr>
					<tr>
						<td>Shipping Total:</td>
						<td><?php echo $this->Form->text("CanteenOrder.shipping_total"); ?> (<?php echo $this->data['CanteenOrder']['currency_id']; ?>)</td>
					</tr>
					<tr>
						<td>Order Total:</td>
						<td><?php echo $this->Form->text("CanteenOrder.total"); ?> (<?php echo $this->data['CanteenOrder']['currency_id']; ?>)</td>
					</tr>
				</table>
				</div>
				<?php echo $this->Form->submit("Update"); ?>
				
		</fieldset>
		<div style='width:50%; float:right; '>
			<fieldset id='credit-debit-forms'>
				<div>
					
				</div>
				<legend>Credit / Debit</legend>
					<div style='padding:5px; background-color:#e9e9e9; font-size:12px; text-align:center;'>
						* Values Entered Will Be Applied In <em>"<?php echo $this->data['Currency']['name']; ?> (<?php echo $this->data['Currency']['id']; ?>) Rate: <?php echo $this->data['Currency']['rate']; ?>"</em>
					</div>
					<div style='width:48%; float:left;' id='credit-form'>
						<?php 
						
							echo $this->Form->input("CanteenOrder.tax_total_credit");
							echo $this->Form->input("CanteenOrder.shipping_total_credit");
							echo $this->Form->input("CanteenOrder.sub_total_credit"); 
							echo $this->Form->input("CanteenOrder.transaction_ref",array("options"=>$charge_list,"label"=>"Choose A Transaction To Reference"));
						?>
						<div style='padding-top:8px; padding-bottom:8px;'>
							<strong>Total Credit:</strong> <span id='total-credit-div'>0.00</span> (<?php echo $this->data['Currency']['id']; ?>)
						</div>
						<?php 
						echo $this->Form->submit("Process Credit",array("name"=>"data[ProcessCredit]"));
						
						?>
					</div>
					<div style='width:48%; float:right;' id='debit-form'>
						<?php 
						
							echo $this->Form->input("CanteenOrder.tax_total_debit");
							echo $this->Form->input("CanteenOrder.shipping_total_debit");
							echo $this->Form->input("CanteenOrder.sub_total_debit"); 
							echo $this->Form->input("CanteenOrder.user_billing_profile_ref_id",array("options"=>$acc_list,"label"=>"Choose a billing profile to debit"));
						?>
						<div style='padding-top:8px; padding-bottom:8px;'>
							<strong>Total Debit:</strong> <span id='total-debit-div'>0.00</span> (<?php echo $this->data['Currency']['id']; ?>)
						</div>
						<?php 
						echo $this->Form->submit("Process Debit",array("name"=>"data[ProcessDebit]"));
						?>
					</div>
					<div style='clear:both;'></div>
			</fieldset>
		</div>
		
		<div style='clear:both'></div>
		<fieldset>
			<legend>Transactions</legend>
			<table cellspacing='0'>
				<tr>
					<th>Created/Modified</th>
					<th>Status</th>
					<th>GatewayAccount</th>
					<th>Method</th>
					<th>Amount</th>
					<th>CC Hash</th>
					<th>Response</th>
				</tr>
				<?php 
					foreach($this->data['GatewayTransaction'] as $t):
				?>
				<tr>
					<td  align='center'>
					<?php echo $this->Time->niceShort($t['created']); ?>/<?php echo $this->Time->niceShort($t['modified']); ?>
					</td>
					<td align='center'>
						<?php 
							switch($t['approved']) {
								
								case 1:
									echo "<span style='color:green;'>Approved</span>";
								break;
								default:
									echo "<span style='color:red;'>Declined</span>";
								break;
							}
						?>
					</td>
					<td align='center'>
						<?php 
							echo $t['GatewayAccount']['name'];
						?>
						(<?php echo $t['GatewayAccount']['provider']; ?>)
					</td>
					<td align='center'><?php echo $t['method']; ?></td>
					<td align='center'>
						<?php echo $t['amount']; ?> (<?php echo $t['GatewayAccount']['currency_id']; ?>)
					</td>
					<td align='center'><?php echo $t['cc_hash']; ?> ()</td> 
					<td>
						<?php echo $t['gateway_response']; ?>
					</td>
				</tr>
				<?php 
					endforeach;
				?>
			</table>
			<div style='text-align:right; padding:5px; font-size:12px; padding-right:20px;'>
				Cash In: <span style='color:green; font-weight:bold;'><?php echo number_format(@($trans_totals['charge']+$trans_totals['capture'])+0,2); ?></span> | 
				Cash Out: <span style='color:red; font-weight:bold;'><?php echo number_format(@($trans_totals['refund'])+0,2); ?></span> | 
				Total Flow: <span style='color:black; font-weight:bold; text-decoration:underline;'><?php echo number_format(@(($trans_totals['charge']+$trans_totals['capture'])-$trans_totals['refund']),2); ?></span>
			</div>
			
			<div style='clear:both;'></div>
		</fieldset>
		<fieldset>
			<legend>Line Items</legend>
			
			<table cellspacing='0'  class='line-items'>
				<tr>
					<th>IMG</th>
					<th>Product</th>
					<th>Quantity</th>
					<th>ShipWeight</th>
					<th>Tax</th>
					<th>Total</th>
					<th>Inv.Status</th>
					<th>-</th>
				</tr>
				<?php 
					foreach($this->data['CanteenOrderItem'] as $k=>$i):
				?>
				<tr <?php foreach($i as $key=>$val) if(!is_array($val)) echo "{$key}='{$val}'"; ?> class='order-item-row'>
					<td width='1%' >
						<?php 
						$img = Set::extract("/CanteenProductImage[thumb_image=1]",$i['CanteenProduct']);
						
						if(count($img)<=0) {
							
							$img = Set::extract("/CanteenProductImage[front_image=1]",$i['CanteenProduct']);
							
						}
					
						echo $this->Media->productThumb($img[0]['CanteenProductImage'],array("h"=>75,"w"=>75));
						?>
						<?php 
						
							echo $this->Form->input("CanteenOrderItem.{$k}.id");
						
						?>
					</td>
					<td>
					<?php 
							
							echo $i['CanteenProduct']['name'];
							if(isset($i['CanteenProductOption']['id'])) {
								
								echo "<br />";
								echo $i['CanteenProductOption']['opt_label'].":".$i['CanteenProductOption']['opt_value'];
								
							}
					?>
					</td>
					<td align='center'><?php echo $i['quantity']; ?></td>
					<td align='center'><?php echo ($i['quantity']*$i['CanteenProduct']['shipping_weight']); ?></td>
					<td align='center'><?php echo $this->Form->input("CanteenOrderItem.{$k}.sales_tax",array("label"=>"({$this->data['CanteenOrder']['currency_id']})")); ?></td>
					<td align='center'><?php echo $this->Form->input("CanteenOrderItem.{$k}.price",array("label"=>"({$this->data['CanteenOrder']['currency_id']})")); ?></td>
					<td align='center'><?php 
						
						switch($i['process_inventory']) {
							
							case 1:
								echo "FULLFILLED";
							break;
							default:
								echo "PENDING";
							break;
							
						}
					
					?></td>
					<td class='actions'>
						<a extra='<?php echo $i['id']; ?>' func='RemoveItem' class='func-link' confirm='Are you sure you want to remove this item?' href='#'>Remove</a>	
					</td>
				</tr>
				<?php 
					endforeach;
				?>
			</table>
			<?php echo $this->Form->submit("Add Item",array("name"=>"data[AddItem]","div"=>array("style"=>"float:left;"))); ?>
			<div style='text-align:right; padding:5px; padding-right:20px; font-size:12px; float:right;'>
				Tax Total: <span><?php echo number_format($line_totals['tax_total']+0,2); ?></span> | 
				Price Total: <span><?php echo number_format($line_totals['price_total']+0,2); ?></span> | 
				Total: <span style='font-weight:bold; text-decoration:underline;'><?php echo number_format(($line_totals['tax_total']+$line_totals['price_total'])+0,2); ?></span>
			</div>
			<div style='clear:both;'></div>
		</fieldset>
		
		<fieldset class='customer-info'>
			<legend>Customer Information</legend>
			<div  style='float:left; width:45%;'>
				<h3>Shipping Information</h3>
				<?php echo $this->element("checkout-forms/shipping-form"); ?>
			</div>
			<div style='float:right; width:45%;'>
				<h3>Billing Info</h3>
				<?php echo $this->element("checkout-forms/billing-form"); ?>
			</div>
			<div style='clear:both;'></div>
		</fieldset>
		
		<fieldset>
			<legend>Email Messages</legend>
			<table cellspacing='0'>
				<tr>
					<th>ID</th>
					<th>Inserted</th>
					<th>Subject</th>
					<th>Template</th>
					<th>Processed</th>
					<th>-</th>
				</tr>
				<?php 
					foreach($this->data['EmailMessage'] as $e):
						
				?>
				<tr>
					<td align='center' width='5%'><?php echo $e['id']?></td>
					<td align='center' width='15%' nowrap><?php echo $this->Time->niceShort($e['created']); ?></td>
					<td align='center' width='15%'><?php echo $e['subject']; ?></td>
					<td align='center'><?php echo $e['template']; ?></td>
					<td align='center'>
					<?php 
					
						switch($e['processed']) {
							
							case 1:
								echo "<span style='color:green;'>Yes</span>";
							break;
							default:
								echo "<span style='color:red;'>No</span>";
							break;
						}
					
					?>
					</td>
					<td class='actions'>
						<a href='/canteen_orders/resend_email/<?php echo $e['id']; ?>/<?php echo base64_encode($this->here); ?>'>Resend</a>
					</td>
				</tr>
				<?php 
					endforeach;
				?>
			</table>
		</fieldset>
		<fieldset>
			<legend>Order Notes</legend>
			<table cellspacing='0'>
				<tr>
					<th>Created</th>
					<th>Public</th>
					<th>User</th>
					<th>Action</th>
					<th>Note</th>
				</tr>
				<?php 
				
					foreach($this->data['CanteenOrderNote'] as $k=>$n):
					
				?>
				<tr>
					<td width='5%' align='center' nowrap><?php echo $this->Time->niceShort($n['created']); ?></td>
					<td width='5%' align='center' nowrap>
						<?php 
							switch($n['public']) {
								
								case 1:
									echo "<span style='color:green;'>Yes</span>";
								break;
								default:
									echo "<span style='color:red;'>Private</span>";
								break;
							}
						?>
					</td>
					<td  align='center'><?php echo $n['User']['first_name']; ?> <?php echo $n['User']['last_name']; ?></td>
					<td align='center'><?php echo $n['action']; ?></td>
					<td><?php echo $n['note']; ?></td>
				</tr>
				<?php 
				
					endforeach;
				
				?>
			</table>
		</fieldset>
		<?php 
		
			echo $this->Form->submit("Update Order");
		
		?>
		</div>
		
		<div style='clear:both;'></div>
	</div>	



	<?php 
		echo $this->Form->end();
	?>
</div>
<?php 
pr($this->data);
?>