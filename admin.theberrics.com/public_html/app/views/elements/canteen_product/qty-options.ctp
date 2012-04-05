<?php 

if(count($this->data['CanteenProductOption'])>0):
?>
<script type='text/javascript'>
$(document).ready(function() { 



	
});

var handleInventorySelect = function(record,product_id) {

	$.ajax({
		"url":"/canteen_products/attach_inventory_record",
		"data":{
			"data":{
				"canteen_inventory_record_id":record.CanteenInventoryRecord.id,
				"canteen_product_id":product_id
			}
		},
		"type":"post",
		"success":function(d) {

			$('#CanteenProductEditForm').submit();
			
			//InventorySearch.closeModal();
			
		}
	});

	return false;
	
}
var removeInventory = function(id) {

	$.ajax({
		"url":"/canteen_products/detach_inventory_record",
		"data":{
			"data":{
				"canteen_product_inventory_id":id
			}
		},
		"type":"post",
		"success":function(d) {
			
			$(document).find("form:eq(0)").submit();
		}
	});
	
}
</script>
<div class='index'>
<table cellspacing='0'>
<tr>
	<th align='left' width='1%'>Sort</th>
	<th align='left'>Label</th>
	<th align='left'>Inventory</th>
	<th align='center'>-</th>
</tr>
<?php 
	foreach($this->data['CanteenProductOption'] as $k=>$o):
	echo $this->Form->input("CanteenProductOption.{$k}.id");
?>
	<tr>
		<td>
			<input type='text' name='data[CanteenProductOption][<?php echo $k; ?>][display_weight]' value='<?php echo $o['display_weight']; ?>' style='width:30px;' />
		</td>
		<td>
			<input type='text' name='data[CanteenProductOption][<?php echo $k; ?>][opt_label]' value='<?php echo $o['opt_label']; ?>' />
		</td>

		<td>
			<?php if(count($o['CanteenProductInventory'])): ?>
				<?php foreach($o['CanteenProductInventory'] as $inv): ?>
					<div><strong>WH:</strong> <?php echo $inv['CanteenInventoryRecord']['Warehouse']['name']; ?> (#:<?php echo $inv['CanteenInventoryRecord']['foreign_key']; ?>) 
						<strong>QTY:</strong> <?php echo $inv['CanteenInventoryRecord']['quantity']; ?> 
						[ <a href='javascript:removeInventory(<?php echo $inv['id']; ?>);'>Remove</a> | <a>Make Priority</a> ]
						</div>
				<?php endforeach; ?>
			<?php else: ?>
			<div class='color:red'>No Inventory Allocated!</div>
			<?php endif; ?>
			<div style='clear:both;'>
				<a href='javascript:InventorySearch.openSearch("handleInventorySelect",<?php echo $o['id']; ?>);'>Attach Inventory</a>
			</div>
		</td>
		<td class='actions'>
			<?php 
			
				echo $this->Form->submit("RemoveOption",array("name"=>"data[RemoveOption][{$o['id']}]"));
			
			?>
		</td>
	</tr>
<?php 
	endforeach;
?>
</table>
	<?php echo $this->Form->submit("Update Options"); 
		echo $this->Form->submit("Add New Option",array("name"=>"data[AddNewOption]"));		
	?>
</div>
<?php 
else:

?>
<?php 

	echo $this->Form->input("quantity");
	echo $this->Form->submit("Update Quantity");
	echo $this->Form->submit("Add Multiple Options",array("name"=>"data[AddNewOption]"));
?>
<?php 

endif;

?>