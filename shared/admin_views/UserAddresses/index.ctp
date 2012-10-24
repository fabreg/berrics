<div class="userAddresses index">
	<h2><?php echo __('User Addresses');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('address_type');?></th>
			<th><?php echo $this->Paginator->sort('first_name');?></th>
			<th><?php echo $this->Paginator->sort('last_name');?></th>
			<th><?php echo $this->Paginator->sort('street');?></th>
			<th><?php echo $this->Paginator->sort('apt');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('postal_code');?></th>
			<th><?php echo $this->Paginator->sort('province');?></th>
			<th><?php echo $this->Paginator->sort('country_code');?></th>
			<th><?php echo $this->Paginator->sort('phone');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('model');?></th>
			<th><?php echo $this->Paginator->sort('foreign_key');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('state');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($userAddresses as $userAddress):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $userAddress['UserAddress']['id']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['created']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['modified']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['address_type']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['first_name']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['last_name']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['street']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['apt']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['city']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['postal_code']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['province']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['country_code']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['phone']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['email']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['model']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['foreign_key']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['user_id']; ?>&nbsp;</td>
		<td><?php echo $userAddress['UserAddress']['state']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Admin->link(__('View'), array('action' => 'view', $userAddress['UserAddress']['id'])); ?>
			<?php echo $this->Admin->link(__('Edit'), array('action' => 'edit', $userAddress['UserAddress']['id'])); ?>
			<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $userAddress['UserAddress']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $userAddress['UserAddress']['id'])); ?>
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
		<li><?php echo $this->Admin->link(__('New User Address'), array('action' => 'add')); ?></li>
	</ul>
</div>