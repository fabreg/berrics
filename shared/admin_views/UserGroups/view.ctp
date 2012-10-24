<div class="userGroups view">
<h2><?php echo __('User Group');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userGroup['UserGroup']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userGroup['UserGroup']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userGroup['UserGroup']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userGroup['UserGroup']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link(__('Edit User Group'), array('action' => 'edit', $userGroup['UserGroup']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('Delete User Group'), array('action' => 'delete', $userGroup['UserGroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $userGroup['UserGroup']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('List User Groups'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User Group'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List User Permissions'), array('controller' => 'user_permissions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User Permission'), array('controller' => 'user_permissions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related User Permissions');?></h3>
	<?php if (!empty($userGroup['UserPermission'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('App Name'); ?></th>
		<th><?php echo __('Controller'); ?></th>
		<th><?php echo __('Action'); ?></th>
		<th><?php echo __('User Group Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($userGroup['UserPermission'] as $userPermission):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $userPermission['id'];?></td>
			<td><?php echo $userPermission['created'];?></td>
			<td><?php echo $userPermission['modified'];?></td>
			<td><?php echo $userPermission['app_name'];?></td>
			<td><?php echo $userPermission['controller'];?></td>
			<td><?php echo $userPermission['action'];?></td>
			<td><?php echo $userPermission['user_group_id'];?></td>
			<td><?php echo $userPermission['user_id'];?></td>
			<td class="actions">
				<?php echo $this->Admin->link(__('View'), array('controller' => 'user_permissions', 'action' => 'view', $userPermission['id'])); ?>
				<?php echo $this->Admin->link(__('Edit'), array('controller' => 'user_permissions', 'action' => 'edit', $userPermission['id'])); ?>
				<?php echo $this->Admin->link(__('Delete'), array('controller' => 'user_permissions', 'action' => 'delete', $userPermission['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $userPermission['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Admin->link(__('New User Permission'), array('controller' => 'user_permissions', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Users');?></h3>
	<?php if (!empty($userGroup['User'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Twitter Oauth Key'); ?></th>
		<th><?php echo __('Twitter Oauth Secret'); ?></th>
		<th><?php echo __('Twitter Account Num'); ?></th>
		<th><?php echo __('Facebook Oauth Key'); ?></th>
		<th><?php echo __('Facebook Oauth Secret'); ?></th>
		<th><?php echo __('Facebook Account Num'); ?></th>
		<th><?php echo __('User Group Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($userGroup['User'] as $user):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $user['id'];?></td>
			<td><?php echo $user['created'];?></td>
			<td><?php echo $user['modified'];?></td>
			<td><?php echo $user['twitter_oauth_key'];?></td>
			<td><?php echo $user['twitter_oauth_secret'];?></td>
			<td><?php echo $user['twitter_account_num'];?></td>
			<td><?php echo $user['facebook_oauth_key'];?></td>
			<td><?php echo $user['facebook_oauth_secret'];?></td>
			<td><?php echo $user['facebook_account_num'];?></td>
			<td><?php echo $user['user_group_id'];?></td>
			<td class="actions">
				<?php echo $this->Admin->link(__('View'), array('controller' => 'users', 'action' => 'view', $user['id'])); ?>
				<?php echo $this->Admin->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?>
				<?php echo $this->Admin->link(__('Delete'), array('controller' => 'users', 'action' => 'delete', $user['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $user['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Admin->link(__('New User'), array('controller' => 'users', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
