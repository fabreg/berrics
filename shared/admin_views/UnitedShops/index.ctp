<div class="unitedShops index">
	<h2><?php echo __('United Shops');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($unitedShops as $unitedShop):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $unitedShop['UnitedShop']['id']; ?>&nbsp;</td>
		<td><?php echo $unitedShop['UnitedShop']['created']; ?>&nbsp;</td>
		<td><?php echo $unitedShop['UnitedShop']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Admin->link(__('View'), array('action' => 'view', $unitedShop['UnitedShop']['id'])); ?>
			<?php echo $this->Admin->link(__('Edit'), array('action' => 'edit', $unitedShop['UnitedShop']['id'])); ?>
			<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $unitedShop['UnitedShop']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $unitedShop['UnitedShop']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link(__('New United Shop'), array('action' => 'add')); ?></li>
	</ul>
</div>