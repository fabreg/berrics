<div class="unifiedStores index">
	<h2><?php echo __('Unified Stores');?></h2>
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
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('shop_name');?></th>
			<th><?php echo $this->Paginator->sort('address1');?></th>
			<th><?php echo $this->Paginator->sort('address2');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('state');?></th>
			<th><?php echo $this->Paginator->sort('full_state');?></th>
			<th><?php echo $this->Paginator->sort('zip');?></th>
			<th><?php echo $this->Paginator->sort('country');?></th>
			<th><?php echo $this->Paginator->sort('phone');?></th>
			<th>Image Logo</th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($unifiedStores as $unifiedStore):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $unifiedStore['UnifiedStore']['id']; ?>&nbsp;</td>
		<td><?php echo $unifiedStore['UnifiedStore']['shop_name']; ?>&nbsp;</td>
		<td><?php echo $unifiedStore['UnifiedStore']['address1']; ?>&nbsp;</td>
		<td><?php echo $unifiedStore['UnifiedStore']['address2']; ?>&nbsp;</td>
		<td><?php echo $unifiedStore['UnifiedStore']['city']; ?>&nbsp;</td>
		<td><?php echo $unifiedStore['UnifiedStore']['state']; ?>&nbsp;</td>
		<td><?php echo $unifiedStore['UnifiedStore']['full_state']; ?>&nbsp;</td>
		<td><?php echo $unifiedStore['UnifiedStore']['zip']; ?>&nbsp;</td>
		<td><?php echo $unifiedStore['UnifiedStore']['country']; ?>&nbsp;</td>
		<td><?php echo $unifiedStore['UnifiedStore']['phone']; ?>&nbsp;</td>
		<td>
			<?php 
				if(!empty($unifiedStore['UnifiedStore']['image_logo'])):
			?>
			<img src='http://img.theberrics.com/i.php?src=/unified-logos/<?php echo $unifiedStore['UnifiedStore']['image_logo']; ?>&w=100' />
			<?php 
				endif;
			?>
		</td>
		<td class="actions">
			
			<?php echo $this->Admin->link(__('Edit'), array('action' => 'edit', $unifiedStore['UnifiedStore']['id'])); ?>
			<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $unifiedStore['UnifiedStore']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $unifiedStore['UnifiedStore']['id'])); ?>
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
		<li><?php echo $this->Admin->link(__('New Unified Store'), array('action' => 'add')); ?></li>
	</ul>
</div>