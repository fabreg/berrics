<div class="unifiedShops index">
	<h2><?php echo __('Unified Shops');?></h2>
	
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
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('street_address');?></th>
			<th><?php echo $this->Paginator->sort('apt_suite');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('state');?></th>
			<th><?php echo $this->Paginator->sort('country');?></th>
			<th><?php echo $this->Paginator->sort('postal_code');?></th>
			<th><?php echo $this->Paginator->sort('phone_number');?></th>
			<th><?php echo $this->Paginator->sort('territory');?></th>
			<th><?php echo $this->Paginator->sort('channel');?></th>
			<th><?php echo $this->Paginator->sort('contact_email');?></th>
			<th><?php echo $this->Paginator->sort('contact_name');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($unifiedShops as $unifiedShop):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		
		<td>
			<?php 
			
				switch($unifiedShop['UnifiedShop']['active']) {
					
					case "1":
						echo "<span style='color:green'>YES</span>";
					break;
					default:
						echo "<span style='color:red'>NO</span>";
					break;
					
				}
			
			?>
		</td>
		<td><?php echo $unifiedShop['UnifiedShop']['modified']; ?>&nbsp;</td>
		<td><?php echo $unifiedShop['UnifiedShop']['name']; ?>&nbsp;</td>
		<td><?php echo $unifiedShop['UnifiedShop']['street_address']; ?>&nbsp;</td>
		<td><?php echo $unifiedShop['UnifiedShop']['apt_suite']; ?>&nbsp;</td>
		<td><?php echo $unifiedShop['UnifiedShop']['city']; ?>&nbsp;</td>
		<td><?php echo $unifiedShop['UnifiedShop']['state']; ?>&nbsp;</td>
		<td><?php echo $unifiedShop['UnifiedShop']['country']; ?>&nbsp;</td>
		<td><?php echo $unifiedShop['UnifiedShop']['postal_code']; ?>&nbsp;</td>
		<td><?php echo $unifiedShop['UnifiedShop']['phone_number']; ?>&nbsp;</td>
		<td><?php echo $unifiedShop['UnifiedShop']['territory']; ?>&nbsp;</td>
		<td><?php echo $unifiedShop['UnifiedShop']['channel']; ?>&nbsp;</td>
		<td><?php echo $unifiedShop['UnifiedShop']['contact_email']; ?>&nbsp;</td>
		<td><?php echo $unifiedShop['UnifiedShop']['contact_name']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Admin->link($unifiedShop['User']['id'], array('controller' => 'users', 'action' => 'view', $unifiedShop['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Admin->link(__('View'), array('action' => 'view', $unifiedShop['UnifiedShop']['id'])); ?>
			<?php echo $this->Admin->link(__('Edit'), array('action' => 'edit', $unifiedShop['UnifiedShop']['id'])); ?>
			<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $unifiedShop['UnifiedShop']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $unifiedShop['UnifiedShop']['id'])); ?>
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
