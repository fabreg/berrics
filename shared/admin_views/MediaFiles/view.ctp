<div class="mediaFiles view">
<h2><?php echo __('Media File');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediaFile['MediaFile']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediaFile['MediaFile']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediaFile['MediaFile']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediaFile['MediaFile']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Admin->link($mediaFile['User']['id'], array('controller' => 'users', 'action' => 'view', $mediaFile['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Media Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediaFile['MediaFile']['media_type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Legacy Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediaFile['MediaFile']['legacy_id']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link(__('Edit Media File'), array('action' => 'edit', $mediaFile['MediaFile']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('Delete Media File'), array('action' => 'delete', $mediaFile['MediaFile']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $mediaFile['MediaFile']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('List Media Files'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Media File'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Media File Users'), array('controller' => 'media_file_users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Media File User'), array('controller' => 'media_file_users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Media File Views'), array('controller' => 'media_file_views', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Media File View'), array('controller' => 'media_file_views', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Dailyops'), array('controller' => 'dailyops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Dailyop'), array('controller' => 'dailyops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Tags'), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Media File Users');?></h3>
	<?php if (!empty($mediaFile['MediaFileUser'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Media File Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
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
				<?php echo $this->Admin->link(__('View'), array('controller' => 'media_file_users', 'action' => 'view', $mediaFileUser['id'])); ?>
				<?php echo $this->Admin->link(__('Edit'), array('controller' => 'media_file_users', 'action' => 'edit', $mediaFileUser['id'])); ?>
				<?php echo $this->Admin->link(__('Delete'), array('controller' => 'media_file_users', 'action' => 'delete', $mediaFileUser['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $mediaFileUser['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Admin->link(__('New Media File User'), array('controller' => 'media_file_users', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Media File Views');?></h3>
	<?php if (!empty($mediaFile['MediaFileView'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Media File Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
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
				<?php echo $this->Admin->link(__('View'), array('controller' => 'media_file_views', 'action' => 'view', $mediaFileView['id'])); ?>
				<?php echo $this->Admin->link(__('Edit'), array('controller' => 'media_file_views', 'action' => 'edit', $mediaFileView['id'])); ?>
				<?php echo $this->Admin->link(__('Delete'), array('controller' => 'media_file_views', 'action' => 'delete', $mediaFileView['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $mediaFileView['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Admin->link(__('New Media File View'), array('controller' => 'media_file_views', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Dailyops');?></h3>
	<?php if (!empty($mediaFile['Dailyop'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Text Content'); ?></th>
		<th><?php echo __('Dailyop Section Id'); ?></th>
		<th><?php echo __('Active'); ?></th>
		<th><?php echo __('Uri'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
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
				<?php echo $this->Admin->link(__('View'), array('controller' => 'dailyops', 'action' => 'view', $dailyop['id'])); ?>
				<?php echo $this->Admin->link(__('Edit'), array('controller' => 'dailyops', 'action' => 'edit', $dailyop['id'])); ?>
				<?php echo $this->Admin->link(__('Delete'), array('controller' => 'dailyops', 'action' => 'delete', $dailyop['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $dailyop['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Admin->link(__('New Dailyop'), array('controller' => 'dailyops', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Tags');?></h3>
	<?php if (!empty($mediaFile['Tag'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Slug'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
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
				<?php echo $this->Admin->link(__('View'), array('controller' => 'tags', 'action' => 'view', $tag['id'])); ?>
				<?php echo $this->Admin->link(__('Edit'), array('controller' => 'tags', 'action' => 'edit', $tag['id'])); ?>
				<?php echo $this->Admin->link(__('Delete'), array('controller' => 'tags', 'action' => 'delete', $tag['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $tag['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Admin->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
