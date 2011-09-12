<div class="locales index">
	<h2><?php __('Locales');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('locale');?></th>
			<th><?php echo $this->Paginator->sort('charset');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($locales as $locale):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $locale['Locale']['id']; ?>&nbsp;</td>
		<td><?php echo $locale['Locale']['created']; ?>&nbsp;</td>
		<td><?php echo $locale['Locale']['modified']; ?>&nbsp;</td>
		<td><?php echo $locale['Locale']['name']; ?>&nbsp;</td>
		<td><?php echo $locale['Locale']['locale']; ?>&nbsp;</td>
		<td><?php echo $locale['Locale']['charset']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $locale['Locale']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $locale['Locale']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $locale['Locale']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $locale['Locale']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Locale', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Offers', true), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer', true), array('controller' => 'offers', 'action' => 'add')); ?> </li>
	</ul>
</div>