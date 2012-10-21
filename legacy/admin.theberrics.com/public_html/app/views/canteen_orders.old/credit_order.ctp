<script>

$(document).ready(function() { 

	
	
	$(".remove_line_item").change(function() { 

		var val = $(this).val();

		toggleLineItem(val);
		
	});

	
});

function toggleLineItem(id) {

	var b = false;
	
	if($("#canteen_order_item_"+id).is(":checked")) {

		b = true;	
		
	} 


	$("#CanteenOrderItem"+id+"Price").attr("disabled",b);
	$("#CanteenOrderItem"+id+"Id").attr("disabled",b);
	$("#CanteenOrderItem"+id+"SalesTax").attr("disabled",b);
	
	
}

</script>
<div class='form index' style='width:70%; margin:auto;'>
	<div style='float:right; width:70%;'>
		<h2>Credit Order</h2>	
		<fieldset>
			<legend>Line Items</legend>
			<?php 
			
				echo $this->Form->create("CanteenOrder",array("url"=>$this->here));
			
			?>
			<div id='line-items'>
				<table cellspacing='0'>
					<tr>
						<th>Remove</th>
						<th>IMG</th>
						<th>Product</th>
						<th>-</th>
					</tr>
					<?php 
					
						foreach($this->data['CanteenOrderItem'] as $k=>$item):
					?>
					<tr>
						<td width='1%' align='center'>
							<input type='checkbox' id='canteen_order_item_<?php echo $k; ?>' value='<?php echo $k; ?>' class='remove_line_item' />
						</td>
						<td width='1%' align='center'>
						<?php 
						
							echo $this->Media->productListThumb($item['CanteenProduct'],array("w"=>75));
						
						?>
						</td>
						<td>
						<?php 
						
							echo $item['CanteenProduct']['name'];
						
						?>
						<?php 
							if(count($item['CanteenProductOption'])>0):
						?>
						<br />
						<?php echo $item['CanteenProductOption']['opt_key']; ?>:<?php echo $item['CanteenProductOption']['opt_value']; ?>
						<?php 
							endif;
						?>
						</td>
						<td>
						<?php 
							
							echo $this->Form->input("CanteenOrderItem.{$k}.id");
							echo $this->Form->input("CanteenOrderItem.{$k}.price");
							echo $this->Form->input("CanteenOrderItem.{$k}.sales_tax");
							
						?>
						</td>
					</tr>
					<?php 
						endforeach;
					?>
				</table>
			</div>
			<div style='width:450px; float:right; margin-top:5px; margin-right:8px;'>
				<table cellspacing='0' >
					<tr>
						<td>
							Sales Tax:
						</td>
						<td>
							
						</td>
					</tr>
					<tr>
						<td>
							Shipping:
						</td>
						<td>
						
						</td>
					</tr>
					<tr>
						<td>Total:</td>
						<td></td>
					</tr>
				</table>
			</div>
			<div style='clear:both;'></div>
			<?php 
			
				echo $this->Form->end("Process Credit");
			
			?>
		</fieldset>
	</div>
	<div style='float:left; width:28%;'>
		<h3>Quick Actions</h3>
		<ul>
			<li>
				<?php 
					echo $this->Form->create();
					echo $this->Form->submit("Full Refund & Return Inventory To Stock");
					echo $this->Form->end();
				?>
			</li>
		</ul>
	</div>
	<div style='clear:both;'></div>
</div>