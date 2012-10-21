<div class='page-header'>
<h1>User Permissions</h1>
</div>
<?php 
echo $this->Admin->adminPaging();
?>
<div class="userPermissions index">
	
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
			<th class="actions"><?php echo __('Actions');?></th>
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
			<?php echo $this->Admin->link($userPermission['UserGroup']['name'], array('controller' => 'user_groups', 'action' => 'view', $userPermission['UserGroup']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Admin->link($userPermission['User']['id'], array('controller' => 'users', 'action' => 'view', $userPermission['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Admin->link(__('View'), array('action' => 'view', $userPermission['UserPermission']['id'])); ?>
			<?php echo $this->Admin->link(__('Edit'), array('action' => 'edit', $userPermission['UserPermission']['id'])); ?>
			<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $userPermission['UserPermission']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $userPermission['UserPermission']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
