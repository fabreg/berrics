<div class="ondemandTitles index">
	<h2><?php __('Ondemand Titles');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('publish_date');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('hd');?></th>
			<th><?php echo $this->Paginator->sort('image_cover');?></th>
			<th><?php echo $this->Paginator->sort('image_back');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($ondemandTitles as $ondemandTitle):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $ondemandTitle['OndemandTitle']['id']; ?>&nbsp;</td>
		<td><?php echo $ondemandTitle['OndemandTitle']['created']; ?>&nbsp;</td>
		<td><?php echo $ondemandTitle['OndemandTitle']['modified']; ?>&nbsp;</td>
		<td><?php echo $ondemandTitle['OndemandTitle']['title']; ?>&nbsp;</td>
		<td><?php echo $ondemandTitle['OndemandTitle']['description']; ?>&nbsp;</td>
		<td><?php echo $ondemandTitle['OndemandTitle']['active']; ?>&nbsp;</td>
		<td><?php echo $ondemandTitle['OndemandTitle']['publish_date']; ?>&nbsp;</td>
		<td><?php echo $ondemandTitle['OndemandTitle']['user_id']; ?>&nbsp;</td>
		<td><?php echo $ondemandTitle['OndemandTitle']['hd']; ?>&nbsp;</td>
		<td><?php echo $ondemandTitle['OndemandTitle']['image_cover']; ?>&nbsp;</td>
		<td><?php echo $ondemandTitle['OndemandTitle']['image_back']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $ondemandTitle['OndemandTitle']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $ondemandTitle['OndemandTitle']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $ondemandTitle['OndemandTitle']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ondemandTitle['OndemandTitle']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Ondemand Title', true), array('action' => 'add')); ?></li>
	</ul>
</div>