<div class="bannerPlacements view">
<h2><?php  __('Banner Placement');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerPlacement['BannerPlacement']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerPlacement['BannerPlacement']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerPlacement['BannerPlacement']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerPlacement['BannerPlacement']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Banner Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($bannerPlacement['BannerType']['name'], array('controller' => 'banner_types', 'action' => 'view', $bannerPlacement['BannerType']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerPlacement['BannerPlacement']['active']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Banner Placement', true), array('action' => 'edit', $bannerPlacement['BannerPlacement']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Banner Placement', true), array('action' => 'delete', $bannerPlacement['BannerPlacement']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bannerPlacement['BannerPlacement']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Placements', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Placement', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Types', true), array('controller' => 'banner_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Type', true), array('controller' => 'banner_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Impressions', true), array('controller' => 'banner_impressions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Impression', true), array('controller' => 'banner_impressions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Banner Impressions');?></h3>
	<?php if (!empty($bannerPlacement['BannerImpression'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Banner Id'); ?></th>
		<th><?php __('Banner Type Id'); ?></th>
		<th><?php __('Banner Placement Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($bannerPlacement['BannerImpression'] as $bannerImpression):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $bannerImpression['id'];?></td>
			<td><?php echo $bannerImpression['created'];?></td>
			<td><?php echo $bannerImpression['banner_id'];?></td>
			<td><?php echo $bannerImpression['banner_type_id'];?></td>
			<td><?php echo $bannerImpression['banner_placement_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'banner_impressions', 'action' => 'view', $bannerImpression['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'banner_impressions', 'action' => 'edit', $bannerImpression['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'banner_impressions', 'action' => 'delete', $bannerImpression['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bannerImpression['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Banner Impression', true), array('controller' => 'banner_impressions', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
