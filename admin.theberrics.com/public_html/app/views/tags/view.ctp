<div class="tags view">
<h2><?php  __('Tag');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tag['Tag']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tag['Tag']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tag['Tag']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tag['Tag']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tag', true), array('action' => 'edit', $tag['Tag']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Tag', true), array('action' => 'delete', $tag['Tag']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tag['Tag']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag', true), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List Dailyop Sections', true), array('controller' => 'dailyop_sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dailyop Section', true), array('controller' => 'dailyop_sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dailyops', true), array('controller' => 'dailyops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dailyop', true), array('controller' => 'dailyops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media Files', true), array('controller' => 'media_files', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media File', true), array('controller' => 'media_files', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Trikipedia Tricks', true), array('controller' => 'trikipedia_tricks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trikipedia Trick', true), array('controller' => 'trikipedia_tricks', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="related">
	<h3><?php __('Related Dailyop Sections');?></h3>
	<?php if (!empty($tag['DailyopSection'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Name'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($tag['DailyopSection'] as $dailyopSection):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $dailyopSection['id'];?></td>
			<td><?php echo $dailyopSection['created'];?></td>
			<td><?php echo $dailyopSection['modified'];?></td>
			<td><?php echo $dailyopSection['name'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'dailyop_sections', 'action' => 'view', $dailyopSection['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'dailyop_sections', 'action' => 'edit', $dailyopSection['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'dailyop_sections', 'action' => 'delete', $dailyopSection['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $dailyopSection['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Dailyop Section', true), array('controller' => 'dailyop_sections', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Dailyops');?></h3>
	<?php if (!empty($tag['Dailyop'])):?>
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
		foreach ($tag['Dailyop'] as $dailyop):
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
	<?php if (!empty($tag['MediaFile'])):?>
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
		foreach ($tag['MediaFile'] as $mediaFile):
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
	<h3><?php __('Related Trikipedia Tricks');?></h3>
	<?php if (!empty($tag['TrikipediaTrick'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Media File Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($tag['TrikipediaTrick'] as $trikipediaTrick):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $trikipediaTrick['id'];?></td>
			<td><?php echo $trikipediaTrick['created'];?></td>
			<td><?php echo $trikipediaTrick['modified'];?></td>
			<td><?php echo $trikipediaTrick['name'];?></td>
			<td><?php echo $trikipediaTrick['media_file_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'trikipedia_tricks', 'action' => 'view', $trikipediaTrick['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'trikipedia_tricks', 'action' => 'edit', $trikipediaTrick['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'trikipedia_tricks', 'action' => 'delete', $trikipediaTrick['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $trikipediaTrick['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Trikipedia Trick', true), array('controller' => 'trikipedia_tricks', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
