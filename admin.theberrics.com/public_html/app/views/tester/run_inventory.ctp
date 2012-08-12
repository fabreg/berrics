<div class='index'>
	
	<table cellspacing='0'>
		<?php foreach($products as $product): ?>
		
			<?php foreach($product['ChildCanteenProduct'] as $c): ?>
			<tr>
				<td width='1%' nowrap ><?php echo $product['CanteenProduct']['name']; ?> - 
					<?php echo $product['CanteenProduct']['sub_title']; ?> - 
					<?php echo $c['opt_label']; ?>:<?php echo $c['opt_value']; ?>
				</td>
				<td width='1%' nowrap >
					<?php echo $c['CanteenProductInventory'][0]['CanteenInventoryRecord']['name']; ?>
				</td>
				<td  width='1%' nowrap >
					<?php echo $c['CanteenProductInventory'][0]['CanteenInventoryRecord']['foreign_key']; ?>
				</td>
				<td  width='1%' nowrap >
					<?php echo $c['CanteenProductInventory'][0]['CanteenInventoryRecord']['Warehouse']['name']; ?>
				</td>
				<td><?php //pr($c['CanteenProductInventory']); ?></td>
			</tr>
			<?php endforeach; ?>
		
		<?php endforeach; ?>
	</table>
	
</div>