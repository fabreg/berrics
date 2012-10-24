<div class="dailyopSections view">
<h2><?php echo __('Dailyop Section');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dailyopSection['DailyopSection']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dailyopSection['DailyopSection']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dailyopSection['DailyopSection']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dailyopSection['DailyopSection']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link(__('Edit Dailyop Section'), array('action' => 'edit', $dailyopSection['DailyopSection']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('Delete Dailyop Section'), array('action' => 'delete', $dailyopSection['DailyopSection']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $dailyopSection['DailyopSection']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('List Dailyop Sections'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Dailyop Section'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Dailyops'), array('controller' => 'dailyops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Dailyop'), array('controller' => 'dailyops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Tags'), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Dailyops');?></h3>
	<?php if (!empty($dailyopSection['Dailyop'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Text Content'); ?></th>
		<th><?php echo __('Dailyop Section Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($dailyopSection['Dailyop'] as $dailyop):
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
	<?php if (!empty($dailyopSection['Tag'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($dailyopSection['Tag'] as $tag):
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
