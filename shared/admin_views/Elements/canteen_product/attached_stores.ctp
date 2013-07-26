<?php if (count($stores)>0): ?>
	<table cellspacing='0'>
		<tr>
			<th>Store</th>
			<th>Actions</th>
		</tr>
		<?php foreach ($stores as $k => $v): ?>
		<tr>
			<td><?php echo $v['UnifiedStore']['shop_name']; ?> (<?php echo $v['UnifiedStore']['city'] ?>)</td>
			<td>
				<button class="btn btn-danger" type='button' onclick='removeStoreItem(<?php echo $v['CanteenProductUnifiedItem']['id'] ?>);'>Remove</button>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<div class="alert">No Stores Attached</div>
<?php endif ?>