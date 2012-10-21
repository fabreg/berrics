<div class="mediahuntTasks view">
<h2><?php echo __('Mediahunt Task');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediahuntTask['MediahuntTask']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediahuntTask['MediahuntTask']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediahuntTask['MediahuntTask']['active']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Mediahunt Event'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Admin->link($mediahuntTask['MediahuntEvent']['name'], array('controller' => 'mediahunt_events', 'action' => 'view', $mediahuntTask['MediahuntEvent']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Sort Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediahuntTask['MediahuntTask']['sort_order']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediahuntTask['MediahuntTask']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Details'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mediahuntTask['MediahuntTask']['details']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link(__('Edit Mediahunt Task'), array('action' => 'edit', $mediahuntTask['MediahuntTask']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('Delete Mediahunt Task'), array('action' => 'delete', $mediahuntTask['MediahuntTask']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $mediahuntTask['MediahuntTask']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('List Mediahunt Tasks'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Mediahunt Task'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Mediahunt Events'), array('controller' => 'mediahunt_events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Mediahunt Event'), array('controller' => 'mediahunt_events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Mediahunt Media Items'), array('controller' => 'mediahunt_media_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Mediahunt Media Item'), array('controller' => 'mediahunt_media_items', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Mediahunt Media Items');?></h3>
	<?php if (!empty($mediahuntTask['MediahuntMediaItem'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modfied'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Media Type'); ?></th>
		<th><?php echo __('Active'); ?></th>
		<th><?php echo __('File Name'); ?></th>
		<th><?php echo __('Approved'); ?></th>
		<th><?php echo __('Rank'); ?></th>
		<th><?php echo __('Mediahunt Task Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
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
				<?php echo $this->Admin->link(__('View'), array('controller' => 'mediahunt_media_items', 'action' => 'view', $mediahuntMediaItem['id'])); ?>
				<?php echo $this->Admin->link(__('Edit'), array('controller' => 'mediahunt_media_items', 'action' => 'edit', $mediahuntMediaItem['id'])); ?>
				<?php echo $this->Admin->link(__('Delete'), array('controller' => 'mediahunt_media_items', 'action' => 'delete', $mediahuntMediaItem['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $mediahuntMediaItem['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Admin->link(__('New Mediahunt Media Item'), array('controller' => 'mediahunt_media_items', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
