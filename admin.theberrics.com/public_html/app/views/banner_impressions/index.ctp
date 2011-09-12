<div class="bannerImpressions index">
	<h2><?php __('Banner Impressions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('banner_id');?></th>
			<th><?php echo $this->Paginator->sort('banner_type_id');?></th>
			<th><?php echo $this->Paginator->sort('banner_placement_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($bannerImpressions as $bannerImpression):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $bannerImpression['BannerImpression']['id']; ?>&nbsp;</td>
		<td><?php echo $bannerImpression['BannerImpression']['created']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($bannerImpression['Banner']['id'], array('controller' => 'banners', 'action' => 'view', $bannerImpression['Banner']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($bannerImpression['BannerType']['name'], array('controller' => 'banner_types', 'action' => 'view', $bannerImpression['BannerType']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($bannerImpression['BannerPlacement']['name'], array('controller' => 'banner_placements', 'action' => 'view', $bannerImpression['BannerPlacement']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $bannerImpression['BannerImpression']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $bannerImpression['BannerImpression']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $bannerImpression['BannerImpression']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bannerImpression['BannerImpression']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Banner Impression', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Types', true), array('controller' => 'banner_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Type', true), array('controller' => 'banner_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Placements', true), array('controller' => 'banner_placements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Placement', true), array('controller' => 'banner_placements', 'action' => 'add')); ?> </li>
	</ul>
</div>