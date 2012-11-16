<div class="page-header">
	<h1>Video Task Servers</h1>
</div>



<?php echo $this->Admin->adminPaging(); ?>
<div class="videoTaskServers index">
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('server'); ?></th>
			<th><?php echo $this->Paginator->sort('active'); ?></th>
			<th><?php echo $this->Paginator->sort('max_tasks'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($videoTaskServers as $videoTaskServer): ?>
	<tr>
		<td><?php echo h($videoTaskServer['VideoTaskServer']['id']); ?>&nbsp;</td>
		<td><?php echo h($videoTaskServer['VideoTaskServer']['modified']); ?>&nbsp;</td>
		<td><?php echo h($videoTaskServer['VideoTaskServer']['server']); ?>&nbsp;</td>
		<td><?php echo h($videoTaskServer['VideoTaskServer']['active']); ?>&nbsp;</td>
		<td><?php echo h($videoTaskServer['VideoTaskServer']['max_tasks']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $videoTaskServer['VideoTaskServer']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $videoTaskServer['VideoTaskServer']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $videoTaskServer['VideoTaskServer']['id']), null, __('Are you sure you want to delete # %s?', $videoTaskServer['VideoTaskServer']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
