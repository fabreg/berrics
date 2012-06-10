<?php 

if(count($this->data['ChildCanteenProduct'])>0):
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
	
};
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
	
};
</script>
<div class='index'>
<table cellspacing='0'>
<tr>
	<th align='left' width='1%'>Sort</th>
	<th align='left'>Label</th>
	<th align='left'>Value</th>
	<th align='left'>Inventory</th>
	<th align='center'>-</th>
</tr>
<?php 
	foreach($this->data['ChildCanteenProduct'] as $k=>$o):
	echo $this->Form->input("ChildCanteenProduct.{$k}.id");
?>
	<tr>
		<td>
			<input type='text' name='data[ChildCanteenProduct][<?php echo $k; ?>][display_weight]' value='<?php echo $o['display_weight']; ?>' style='width:30px;' />
		</td>
		<td>
			<input type='text' name='data[ChildCanteenProduct][<?php echo $k; ?>][opt_label]' value='<?php echo $o['opt_label']; ?>' />
		</td>
		<td>
			<input type='text' name='data[ChildCanteenProduct][<?php echo $k; ?>][opt_value]' value='<?php echo $o['opt_value']; ?>' />
		</td>
		<td>
			<?php if(count($o['CanteenProductInventory'])): ?>
				<?php foreach($o['CanteenProductInventory'] as $inv): ?>
					<div>
						<?php if($inv['priority']): ?>
						<span style='color:green;'>PRIORITY</span>
						<?php endif; ?> 
						<strong>QTY:</strong> <?php echo $inv['CanteenInventoryRecord']['quantity']; ?> 
						<strong>WH:</strong> <?php echo $inv['CanteenInventoryRecord']['Warehouse']['name']; ?>
						 <strong>ITEM#:</strong> <?php echo $inv['CanteenInventoryRecord']['foreign_key']; ?>  
						<strong>NAME: </strong><?php echo $inv['CanteenInventoryRecord']['name']; ?>
						[ <a href='javascript:removeInventory(<?php echo $inv['id']; ?>);'>Remove</a> 
						<?php if(!$inv['priority']): ?>
							| <a href='/canteen_products/make_inventory_priority/<?php echo $o['id']; ?>/<?php echo $inv['id']; ?>/callback:<?php echo base64_encode($this->here."#Options & Inventory"); ?>'>Make Record Priority</a>
						<?php endif; ?>
						]
						</div>
				<?php endforeach; ?>
			<?php else: ?>
			<div class='color:red'>No Inventory Allocated!</div>
			<?php endif; ?>
			<div style='clear:both;'>
				<a href='javascript:InventorySearch.openSearch("handleInventorySelect",<?php echo $o['id']; ?>);'>Attach Inventory</a>
				<a href='/canteen_inventory_records/add/callback:<?php echo base64_encode($this->here."#Options & Inventory"); ?>/canteen_product_id:<?php echo $o['id']; ?>'>Create And Attach Inventory</a>
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
	<?php echo $this->Form->submit("Update Options",array("name"=>"data[UpdateOptions]")); 
		echo $this->Form->submit("Add New Option",array("name"=>"data[AddNewOption]"));		
	?>
</div>
<?php 
else:

?>
<?php 

	
	echo $this->Form->submit("Add A Purchase Option",array("name"=>"data[AddNewOption]"));
	echo $this->Form->submit("** Add Common Shirt Options **",array("name"=>"data[AddCommonShirtOptions]"));
	echo $this->Form->submit("** Add Common Pants Options **",array("name"=>"data[AddCommonPantsOptions]"));
	echo $this->Form->submit("** Add Common Hat Options **",array("name"=>"data[AddCommonHatOptions]"));
?>
<?php 

endif;

?>