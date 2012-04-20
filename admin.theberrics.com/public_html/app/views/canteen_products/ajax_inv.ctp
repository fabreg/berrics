<table cellspacing='0' style='width:50%;' align='right'>
	<tr>
		<th>Label</th>
		<th>Inventory Record</th>
	</tr>
	<?php if(count($product['ChildCanteenProduct'])>0): ?>
	<?php foreach($product['ChildCanteenProduct'] as $item): ?>
	<tr>
		<td>
			<?php echo $item['opt_label']; ?>:<?php echo $item['opt_value']; ?>
		</td>
		<td>
		<?php if(count($item['CanteenProductInventory'])>0): ?>
			<?php foreach($item['CanteenProductInventory'] as $inv): ?>
			<div>
			<strong>WH: </strong><?php echo $inv['CanteenInventoryRecord']['Warehouse']['name']; ?> 
			<strong>QTY: </strong><?php echo $inv['CanteenInventoryRecord']['quantity']; ?> 
			<strong>QTY ALLOCATED: </strong><?php echo $inv['CanteenInventoryRecord']['allocated']; ?> 
			<strong>TOTAL QTY: </strong><?php echo $inv['CanteenInventoryRecord']['allocated']+$inv['CanteenInventoryRecord']['quantity']; ?> 
			</div>
			<?php endforeach; ?>
		<?php else: ?>
			No Inventory Records Have Been Attached
		<?php endif; ?>
		
		</td>
	</tr>
	<?php endforeach; ?>
	<?php else: ?>
	<tr>
		<td colspan='2'>No Options Have Been Set</td>
	</tr>
	<?php endif; ?>
	
</table>