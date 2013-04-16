<div class="dailyopsConfigs index">
	<h2><?php echo __('Dailyops Configs'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('dailyops_date'); ?></th>
			<th><?php echo $this->Paginator->sort('post_frequency'); ?></th>
			<th><?php echo $this->Paginator->sort('disable_themes'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($dailyopsConfigs as $dailyopsConfig): ?>
	<tr>
		<td><?php echo h($dailyopsConfig['DailyopsConfig']['id']); ?>&nbsp;</td>
		<td><?php echo h($dailyopsConfig['DailyopsConfig']['modified']); ?>&nbsp;</td>
		<td><?php echo h($dailyopsConfig['DailyopsConfig']['dailyops_date']); ?>&nbsp;</td>
		<td><?php echo h($dailyopsConfig['DailyopsConfig']['post_frequency']); ?>&nbsp;</td>
		<td><?php echo h($dailyopsConfig['DailyopsConfig']['disable_themes']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $dailyopsConfig['DailyopsConfig']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $dailyopsConfig['DailyopsConfig']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $dailyopsConfig['DailyopsConfig']['id']), null, __('Are you sure you want to delete # %s?', $dailyopsConfig['DailyopsConfig']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Dailyops Config'), array('action' => 'add')); ?></li>
	</ul>
</div>
