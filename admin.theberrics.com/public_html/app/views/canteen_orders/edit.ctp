<script>
$(document).ready(function() { 

	$('.tab-fields').prepend("<div id='tab-nav'><ul></ul><div style='clear:both;'></div></div>");
	
	$('.tab-fields fieldset').each(function() { 
		var l = $(this).find("legend");
		$('#tab-nav ul').append("<li>"+$(l).text()+"</li>");
	});

	$('#tab-nav li').css({
		"float":"left",
		"margin-right":"5px",
		"list-style":"none",
		"border":"1px solid #000",
		"padding":"5px",
		"cursor":"pointer"
	}).click(function() { 

		var ind = $(this).index();

		selectSet(ind);
		
	});

	selectSet(0);

	detectHash();
	
});

function detectHash() {

	var h = document.location.hash;

	if(h.length>1) {

		h = h.replace(/#/,'');

		h = h.toLowerCase();
		
		$('#tab-nav li').each(function() { 

			var t = $(this).text().toLowerCase();

			if(t==h) {

				selectSet($(this).index());

			}
			
		});
		
	}
	
}

function hideAllSets() {

	$('.tab-fields fieldset').hide();

	$('#tab-nav li').css({
		"background-color":""
	});
	
}

function selectSet(ind) {

	hideAllSets();

	$("#tab-nav li:eq("+ind+")").css({
		"background-color":"#e9e9e9"
	});

	$(".tab-fields fieldset:eq("+ind+")").show();
	
}

</script>
<style>
.big-table td {

	font-size:18px;

}
.big-table td:nth-child(0) {

	font-weight:bold;

}

.address-div {

	float:left;
	width:350px;
	

}
.address-div td:nth-child(1) {

		text-align:right;
		width:35%;
		font-weight:bold;
}
</style>
<div class='form index'>
	<h2>Edit Order: <?php echo $this->data['CanteenOrder']['id']; ?></h2>
	<fieldset>
		<legend>General Info</legend>
		<div>
			<div style='float:left; width:40%;'>
				<table cellspacing='0' class='big-table'>
					<tr>
						<td width='30%' align='right'>Order Status</td>
						<td><?php echo strtoupper($this->data['CanteenOrder']['order_status']); ?></td>
					</tr>
					<tr>
						<td width='30%' align='right'>Fulfillment Status</td>
						<td><?php echo strtoupper($this->data['CanteenOrder']['fulfillment_status']); ?></td>
					</tr>
					<tr>
						<td width='30%' align='right'>Shipping Status</td>
						<td><?php echo strtoupper($this->data['CanteenOrder']['shipping_status']); ?></td>
					</tr>
					<tr>
						<td width='30%' align='right'>Currency</td>
						<td><?php 
								echo $this->data['Currency']['name'];  

								if($this->data['Currency']['id'] != "USD") {
									
									echo " ({$this->data['Currency']['rate']} VS. USD)";
									
								}
								
						?></td>
					</tr>
					<tr>
						<td width='30%' align='right'>Sub Total</td>
						<td><?php echo $this->Number->currency($this->data['CanteenOrder']['sub_total'],$this->data['Currency']['id']); ?></td>
					</tr>
					<tr>
						<td width='30%' align='right'>Tax Total</td>
						<td><?php echo $this->Number->currency($this->data['CanteenOrder']['tax_total'],$this->data['Currency']['id']); ?></td>
					</tr>
					<tr>
						<td width='30%' align='right'>Shipping Total</td>
						<td><?php echo $this->Number->currency($this->data['CanteenOrder']['shipping_total'],$this->data['Currency']['id']); ?></td>
					</tr>
				</table>
			</div>
			<div style='float:left; width:40%;'>
			
			</div>
			<div style='clear:both;'></div>
		</div>
	</fieldset>
	<div class='tab-fields'>
		<fieldset>
			<legend>Addresses</legend>
			<div>
				<?php foreach($this->data['UserAddress'] as $v): ?>
				<div class='address-div'>
					<table cellspacing='0'>
						<tr>
							<td>Address Type</td>
							<td><?php echo strtoupper($v['address_type']); ?></td>
						</tr>
						<tr>
							<td>First Name</td>
							<td><?php echo $v['first_name']; ?></td>
						</tr>
						<tr>
							<td>Last Name</td>
							<td><?php echo $v['last_name']; ?></td>
						</tr>
						<tr>
							<td>Street</td>
							<td><?php echo $v['street']; ?></td>
						</tr>
						<tr>
							<td>Apt</td>
							<td><?php echo $v['apt']; ?></td>
						</tr>
						<tr>
							<td>City</td>
							<td><?php echo $v['city']; ?></td>
						</tr>
						<tr>
							<td>State/Province</td>
							<td><?php echo $v['state']; ?></td>
						</tr>
						<tr>
							<td>Postal</td>
							<td><?php echo $v['postal_code']; ?></td>
						</tr>
						<tr>
							<td>Country Code</td>
							<td><?php echo $v['country_code']; ?></td>
						</tr>
						<tr>
							<td>Phone</td>
							<td><?php echo $v['phone']; ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?php echo $v['email']; ?></td>
						</tr>
						<tr>
							<td>ID</td>
							<td><?php echo $v['id']; ?></td>
						</tr>
						<tr>
							<td colspan='2' class='actions'>
								<a href='/user_addresses/edit/<?php echo $v['id']; ?>/callback:<?php echo base64_encode($this->here); ?>'>Edit</a>
							</td>
						</tr>
					</table>
				</div>
				<?php endforeach;?>
				<div style='clear:both;'></div>
			</div>
		</fieldset>
		<fieldset>
			<legend>Cart Items</legend>
		</fieldset>
		<fieldset>
			<legend>Transactions</legend>
		</fieldset>
	</div>
</div>