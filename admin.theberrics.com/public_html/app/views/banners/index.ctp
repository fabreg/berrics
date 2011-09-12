<div class="banners index">
	<h2><?php __('Banners');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('file_name');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('continent_code');?></th>
			<th><?php echo $this->Paginator->sort('country_code');?></th>
			<th><?php echo $this->Paginator->sort('province_code');?></th>
			<th><?php echo $this->Paginator->sort('banner_type_id');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('destination_url');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($banners as $banner):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $banner['Banner']['id']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['created']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['modified']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['file_name']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($banner['User']['id'], array('controller' => 'users', 'action' => 'view', $banner['User']['id'])); ?>
		</td>
		<td><?php echo $banner['Banner']['description']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['continent_code']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['country_code']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['province_code']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($banner['BannerType']['name'], array('controller' => 'banner_types', 'action' => 'view', $banner['BannerType']['id'])); ?>
		</td>
		<td><?php echo $banner['Banner']['active']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['destination_url']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $banner['Banner']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $banner['Banner']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $banner['Banner']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $banner['Banner']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Banner', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Types', true), array('controller' => 'banner_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Type', true), array('controller' => 'banner_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Clicks', true), array('controller' => 'banner_clicks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Click', true), array('controller' => 'banner_clicks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Impressions', true), array('controller' => 'banner_impressions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Impression', true), array('controller' => 'banner_impressions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags', true), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag', true), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>