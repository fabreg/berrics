<div class="users view">
<h2><?php  __('User');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Twitter Oauth Key'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['twitter_oauth_key']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Twitter Oauth Secret'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['twitter_oauth_secret']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Twitter Account Num'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['twitter_account_num']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Facebook Oauth Key'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['facebook_oauth_key']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Facebook Oauth Secret'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['facebook_oauth_secret']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Facebook Account Num'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['facebook_account_num']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User Group'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($user['UserGroup']['name'], array('controller' => 'user_groups', 'action' => 'view', $user['UserGroup']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User', true), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Groups', true), array('controller' => 'user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Group', true), array('controller' => 'user_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dailyops', true), array('controller' => 'dailyops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dailyop', true), array('controller' => 'dailyops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media Files', true), array('controller' => 'media_files', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media File', true), array('controller' => 'media_files', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Permissions', true), array('controller' => 'user_permissions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Permission', true), array('controller' => 'user_permissions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Banners');?></h3>
	<?php if (!empty($user['Banner'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('File Name'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Continent Code'); ?></th>
		<th><?php __('Country Code'); ?></th>
		<th><?php __('Province Code'); ?></th>
		<th><?php __('Banner Type Id'); ?></th>
		<th><?php __('Active'); ?></th>
		<th><?php __('Destination Url'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Banner'] as $banner):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $banner['id'];?></td>
			<td><?php echo $banner['created'];?></td>
			<td><?php echo $banner['modified'];?></td>
			<td><?php echo $banner['file_name'];?></td>
			<td><?php echo $banner['user_id'];?></td>
			<td><?php echo $banner['description'];?></td>
			<td><?php echo $banner['continent_code'];?></td>
			<td><?php echo $banner['country_code'];?></td>
			<td><?php echo $banner['province_code'];?></td>
			<td><?php echo $banner['banner_type_id'];?></td>
			<td><?php echo $banner['active'];?></td>
			<td><?php echo $banner['destination_url'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'banners', 'action' => 'view', $banner['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'banners', 'action' => 'edit', $banner['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'banners', 'action' => 'delete', $banner['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $banner['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Dailyops');?></h3>
	<?php if (!empty($user['Dailyop'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Text Content'); ?></th>
		<th><?php __('Dailyop Section Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Dailyop'] as $dailyop):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $dailyop['id'];?></td>
			<td><?php echo $dailyop['created'];?></td>
			<td><?php echo $dailyop['modified'];?></td>
			<td><?php echo $dailyop['name'];?></td>
			<td><?php echo $dailyop['user_id'];?></td>
			<td><?php echo $dailyop['text_content'];?></td>
			<td><?php echo $dailyop['dailyop_section_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'dailyops', 'action' => 'view', $dailyop['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'dailyops', 'action' => 'edit', $dailyop['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'dailyops', 'action' => 'delete', $dailyop['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $dailyop['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Dailyop', true), array('controller' => 'dailyops', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Media Files');?></h3>
	<?php if (!empty($user['MediaFile'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modifed'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['MediaFile'] as $mediaFile):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $mediaFile['id'];?></td>
			<td><?php echo $mediaFile['created'];?></td>
			<td><?php echo $mediaFile['modifed'];?></td>
			<td><?php echo $mediaFile['name'];?></td>
			<td><?php echo $mediaFile['user_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'media_files', 'action' => 'view', $mediaFile['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'media_files', 'action' => 'edit', $mediaFile['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'media_files', 'action' => 'delete', $mediaFile['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mediaFile['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Media File', true), array('controller' => 'media_files', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related User Permissions');?></h3>
	<?php if (!empty($user['UserPermission'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('App Name'); ?></th>
		<th><?php __('Controller'); ?></th>
		<th><?php __('Action'); ?></th>
		<th><?php __('User Group Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['UserPermission'] as $userPermission):
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
				<?php echo $this->Html->link(__('View', true), array('controller' => 'user_permissions', 'action' => 'view', $userPermission['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'user_permissions', 'action' => 'edit', $userPermission['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'user_permissions', 'action' => 'delete', $userPermission['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userPermission['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User Permission', true), array('controller' => 'user_permissions', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
