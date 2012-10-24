<div class="tags index">
	<h2><?php __('Tags');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($tags as $tag):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $tag['Tag']['id']; ?>&nbsp;</td>
		<td><?php echo $tag['Tag']['created']; ?>&nbsp;</td>
		<td><?php echo $tag['Tag']['modified']; ?>&nbsp;</td>
		<td><?php echo $tag['Tag']['name']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $tag['Tag']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $tag['Tag']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $tag['Tag']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tag['Tag']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Tag', true), array('action' => 'add')); ?></li>
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