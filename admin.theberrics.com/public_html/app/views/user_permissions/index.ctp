<div class="userPermissions index">
	<h2><?php __('User Permissions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('app_name');?></th>
			<th><?php echo $this->Paginator->sort('controller');?></th>
			<th><?php echo $this->Paginator->sort('action');?></th>
			<th><?php echo $this->Paginator->sort('user_group_id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($userPermissions as $userPermission):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $userPermission['UserPermission']['id']; ?>&nbsp;</td>
		<td><?php echo $userPermission['UserPermission']['created']; ?>&nbsp;</td>
		<td><?php echo $userPermission['UserPermission']['modified']; ?>&nbsp;</td>
		<td><?php echo $userPermission['UserPermission']['app_name']; ?>&nbsp;</td>
		<td><?php echo $userPermission['UserPermission']['controller']; ?>&nbsp;</td>
		<td><?php echo $userPermission['UserPermission']['action']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($userPermission['UserGroup']['name'], array('controller' => 'user_groups', 'action' => 'view', $userPermission['UserGroup']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($userPermission['User']['id'], array('controller' => 'users', 'action' => 'view', $userPermission['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $userPermission['UserPermission']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $userPermission['UserPermission']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $userPermission['UserPermission']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userPermission['UserPermission']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New User Permission', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List User Groups', true), array('controller' => 'user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Group', true), array('controller' => 'user_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>