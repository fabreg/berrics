<div class='index'>
	<table cellspacing='0'>
		<tr>
			<th>Name</th>
			<th>Item Number</th>
			<th>Warehouse</th>
			<th>Quantity</th>
			<th>-</th>
		</tr>
		<?php foreach($records as $record): 
				$r = $record['CanteenInventoryRecord'];
		?>
		<tr>
			<td><?php echo $r['name']; ?></td>
			<td><?php echo $r['foreign_key']; ?></td>
			<td><?php echo $record['Warehouse']['name']; ?></td>
			<td><?php echo $r['quantity']; ?></td>
			<td class='actions'>
				<a href='javascript:InventorySearch.handleSelect(<?php echo json_encode($record); ?>);'>
					Select
				</a>
			</td>
		</tr>
		<?php endforeach;?>
	</table>
</div>