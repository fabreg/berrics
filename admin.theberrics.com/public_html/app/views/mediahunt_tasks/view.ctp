<div class="mediahuntTasks view">
<h2><?php  __('Mediahunt Task');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediahuntTask['MediahuntTask']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediahuntTask['MediahuntTask']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediahuntTask['MediahuntTask']['active']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mediahunt Event'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($mediahuntTask['MediahuntEvent']['name'], array('controller' => 'mediahunt_events', 'action' => 'view', $mediahuntTask['MediahuntEvent']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sort Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediahuntTask['MediahuntTask']['sort_order']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediahuntTask['MediahuntTask']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Details'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediahuntTask['MediahuntTask']['details']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Mediahunt Task', true), array('action' => 'edit', $mediahuntTask['MediahuntTask']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Mediahunt Task', true), array('action' => 'delete', $mediahuntTask['MediahuntTask']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mediahuntTask['MediahuntTask']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Mediahunt Tasks', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediahunt Task', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Mediahunt Events', true), array('controller' => 'mediahunt_events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediahunt Event', true), array('controller' => 'mediahunt_events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Mediahunt Media Items', true), array('controller' => 'mediahunt_media_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediahunt Media Item', true), array('controller' => 'mediahunt_media_items', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Mediahunt Media Items');?></h3>
	<?php if (!empty($mediahuntTask['MediahuntMediaItem'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modfied'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Media Type'); ?></th>
		<th><?php __('Active'); ?></th>
		<th><?php __('File Name'); ?></th>
		<th><?php __('Approved'); ?></th>
		<th><?php __('Rank'); ?></th>
		<th><?php __('Mediahunt Task Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mediahuntTask['MediahuntMediaItem'] as $mediahuntMediaItem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $mediahuntMediaItem['id'];?></td>
			<td><?php echo $mediahuntMediaItem['created'];?></td>
			<td><?php echo $mediahuntMediaItem['modfied'];?></td>
			<td><?php echo $mediahuntMediaItem['user_id'];?></td>
			<td><?php echo $mediahuntMediaItem['title'];?></td>
			<td><?php echo $mediahuntMediaItem['description'];?></td>
			<td><?php echo $mediahuntMediaItem['media_type'];?></td>
			<td><?php echo $mediahuntMediaItem['active'];?></td>
			<td><?php echo $mediahuntMediaItem['file_name'];?></td>
			<td><?php echo $mediahuntMediaItem['approved'];?></td>
			<td><?php echo $mediahuntMediaItem['rank'];?></td>
			<td><?php echo $mediahuntMediaItem['mediahunt_task_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'mediahunt_media_items', 'action' => 'view', $mediahuntMediaItem['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'mediahunt_media_items', 'action' => 'edit', $mediahuntMediaItem['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'mediahunt_media_items', 'action' => 'delete', $mediahuntMediaItem['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mediahuntMediaItem['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Mediahunt Media Item', true), array('controller' => 'mediahunt_media_items', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
