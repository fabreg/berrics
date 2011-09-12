<div class="mediaFiles view">
<h2><?php  __('Media File');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediaFile['MediaFile']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediaFile['MediaFile']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediaFile['MediaFile']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediaFile['MediaFile']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($mediaFile['User']['id'], array('controller' => 'users', 'action' => 'view', $mediaFile['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Media Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediaFile['MediaFile']['media_type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Legacy Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediaFile['MediaFile']['legacy_id']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Media File', true), array('action' => 'edit', $mediaFile['MediaFile']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Media File', true), array('action' => 'delete', $mediaFile['MediaFile']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mediaFile['MediaFile']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Media Files', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media File', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media File Users', true), array('controller' => 'media_file_users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media File User', true), array('controller' => 'media_file_users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media File Views', true), array('controller' => 'media_file_views', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media File View', true), array('controller' => 'media_file_views', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dailyops', true), array('controller' => 'dailyops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dailyop', true), array('controller' => 'dailyops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags', true), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag', true), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Media File Users');?></h3>
	<?php if (!empty($mediaFile['MediaFileUser'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Media File Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mediaFile['MediaFileUser'] as $mediaFileUser):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $mediaFileUser['id'];?></td>
			<td><?php echo $mediaFileUser['media_file_id'];?></td>
			<td><?php echo $mediaFileUser['user_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'media_file_users', 'action' => 'view', $mediaFileUser['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'media_file_users', 'action' => 'edit', $mediaFileUser['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'media_file_users', 'action' => 'delete', $mediaFileUser['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mediaFileUser['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Media File User', true), array('controller' => 'media_file_users', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Media File Views');?></h3>
	<?php if (!empty($mediaFile['MediaFileView'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Media File Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mediaFile['MediaFileView'] as $mediaFileView):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $mediaFileView['id'];?></td>
			<td><?php echo $mediaFileView['created'];?></td>
			<td><?php echo $mediaFileView['modified'];?></td>
			<td><?php echo $mediaFileView['media_file_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'media_file_views', 'action' => 'view', $mediaFileView['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'media_file_views', 'action' => 'edit', $mediaFileView['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'media_file_views', 'action' => 'delete', $mediaFileView['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mediaFileView['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Media File View', true), array('controller' => 'media_file_views', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Dailyops');?></h3>
	<?php if (!empty($mediaFile['Dailyop'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Text Content'); ?></th>
		<th><?php __('Dailyop Section Id'); ?></th>
		<th><?php __('Active'); ?></th>
		<th><?php __('Uri'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mediaFile['Dailyop'] as $dailyop):
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
			<td><?php echo $dailyop['active'];?></td>
			<td><?php echo $dailyop['uri'];?></td>
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
	<h3><?php __('Related Tags');?></h3>
	<?php if (!empty($mediaFile['Tag'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Slug'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mediaFile['Tag'] as $tag):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $tag['id'];?></td>
			<td><?php echo $tag['created'];?></td>
			<td><?php echo $tag['modified'];?></td>
			<td><?php echo $tag['name'];?></td>
			<td><?php echo $tag['slug'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'tags', 'action' => 'view', $tag['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'tags', 'action' => 'edit', $tag['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'tags', 'action' => 'delete', $tag['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tag['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Tag', true), array('controller' => 'tags', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
