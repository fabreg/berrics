<div class='index'>
	<h2>Canteen Products</h2>
	<table cellspacing='0'>
		<tr>
			<th>Front Image</th>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("name"); ?></th>
			<th><?php echo $this->Paginator->sort("CanteenCategory.name"); ?></th>
			<th>-</th>
		</tr>
		<?php 
		
			foreach($products as $prod):
				$p = $prod['CanteenProduct'];
				$c = $prod['CanteenCategory'];
		?>
		<tr>
			<td>
				<?php if(isset($prod['CanteenProductImage'][0])): ?>
				<?php echo $this->Media->productThumb($prod['CanteenProductImage'][0],array("w"=>120)); ?>
				<?php else: ?>
				No Image
				<?php endif; ?>
			</td>
			<td><?php echo $p['id']; ?></td>
			<td><?php echo $p['modified']; ?></td>
			<td><?php echo $p['name']; ?></td>
			<td><?php echo $c['name']; ?></td>
			<td class='actions'>
				<a href='/canteen_products/edit/<?php echo $p['id']; ?>/<?php echo base64_encode($this->here); ?>'>Edit</a>
			</td>
		</tr>
		<?php 
		
			endforeach;
		
		?>
	</table>
</div>