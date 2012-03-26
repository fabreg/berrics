<div class="systemMessages index">
	<h2><?php __('System Messages');?></h2>
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
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('category');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('message');?></th>
			<th><?php echo $this->Paginator->sort('crontab');?></th>
			<th><?php echo $this->Paginator->sort('alert');?></th>
			<th><?php echo $this->Paginator->sort('from');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($systemMessages as $systemMessage):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $systemMessage['SystemMessage']['id']; ?>&nbsp;</td>
		<td><?php echo $systemMessage['SystemMessage']['created']; ?>&nbsp;</td>
		<td><?php echo $systemMessage['SystemMessage']['modified']; ?>&nbsp;</td>
		<td><?php echo $systemMessage['SystemMessage']['category']; ?>&nbsp;</td>
		<td><?php echo $systemMessage['SystemMessage']['title']; ?>&nbsp;</td>
		<td><?php echo $systemMessage['SystemMessage']['message']; ?>&nbsp;</td>
		<td><?php echo $systemMessage['SystemMessage']['crontab']; ?>&nbsp;</td>
		<td><?php echo $systemMessage['SystemMessage']['alert']; ?>&nbsp;</td>
		<td><?php echo $systemMessage['SystemMessage']['from']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $systemMessage['SystemMessage']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $systemMessage['SystemMessage']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $systemMessage['SystemMessage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $systemMessage['SystemMessage']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New System Message', true), array('action' => 'add')); ?></li>
	</ul>
</div>