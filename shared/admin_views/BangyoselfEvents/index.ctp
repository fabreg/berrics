<div class="bangyoselfEvents index">
	<h2><?php echo __('Bangyoself Events');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($bangyoselfEvents as $bangyoselfEvent):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $bangyoselfEvent['BangyoselfEvent']['id']; ?>&nbsp;</td>
		<td><?php echo $bangyoselfEvent['BangyoselfEvent']['created']; ?>&nbsp;</td>
		<td><?php echo $bangyoselfEvent['BangyoselfEvent']['modified']; ?>&nbsp;</td>
		<td><?php echo $bangyoselfEvent['BangyoselfEvent']['name']; ?>&nbsp;</td>
		<td><?php echo $bangyoselfEvent['BangyoselfEvent']['description']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Admin->link(__('View Entries'), array('action' => 'view', $bangyoselfEvent['BangyoselfEvent']['id'])); ?>
			<?php echo $this->Admin->link(__('Edit'), array('action' => 'edit', $bangyoselfEvent['BangyoselfEvent']['id'])); ?>
			<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $bangyoselfEvent['BangyoselfEvent']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $bangyoselfEvent['BangyoselfEvent']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link(__('New Bangyoself Event'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Admin->link(__('List Bangyoself Entries'), array('controller' => 'bangyoself_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Bangyoself Entry'), array('controller' => 'bangyoself_entries', 'action' => 'add')); ?> </li>
	</ul>
</div>