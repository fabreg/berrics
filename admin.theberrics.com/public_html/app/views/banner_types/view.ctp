<div class="bannerTypes view">
<h2><?php  __('Banner Type');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerType['BannerType']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerType['BannerType']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerType['BannerType']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Width'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerType['BannerType']['width']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Height'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerType['BannerType']['height']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerType['BannerType']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Banner Type', true), array('action' => 'edit', $bannerType['BannerType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Banner Type', true), array('action' => 'delete', $bannerType['BannerType']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bannerType['BannerType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Types', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Type', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Impressions', true), array('controller' => 'banner_impressions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Impression', true), array('controller' => 'banner_impressions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Placements', true), array('controller' => 'banner_placements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Placement', true), array('controller' => 'banner_placements', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Banner Impressions');?></h3>
	<?php if (!empty($bannerType['BannerImpression'])):?>
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
		foreach ($bannerType['BannerImpression'] as $bannerImpression):
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
<div class="related">
	<h3><?php __('Related Banner Placements');?></h3>
	<?php if (!empty($bannerType['BannerPlacement'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Banner Type Id'); ?></th>
		<th><?php __('Active'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($bannerType['BannerPlacement'] as $bannerPlacement):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $bannerPlacement['id'];?></td>
			<td><?php echo $bannerPlacement['created'];?></td>
			<td><?php echo $bannerPlacement['modified'];?></td>
			<td><?php echo $bannerPlacement['name'];?></td>
			<td><?php echo $bannerPlacement['banner_type_id'];?></td>
			<td><?php echo $bannerPlacement['active'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'banner_placements', 'action' => 'view', $bannerPlacement['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'banner_placements', 'action' => 'edit', $bannerPlacement['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'banner_placements', 'action' => 'delete', $bannerPlacement['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bannerPlacement['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Banner Placement', true), array('controller' => 'banner_placements', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Banners');?></h3>
	<?php if (!empty($bannerType['Banner'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('File Name'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Continent Code'); ?></th>
		<th><?php __('Country Code'); ?></th>
		<th><?php __('Province Code'); ?></th>
		<th><?php __('Banner Type Id'); ?></th>
		<th><?php __('Active'); ?></th>
		<th><?php __('Destination Url'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($bannerType['Banner'] as $banner):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $banner['id'];?></td>
			<td><?php echo $banner['created'];?></td>
			<td><?php echo $banner['modified'];?></td>
			<td><?php echo $banner['file_name'];?></td>
			<td><?php echo $banner['user_id'];?></td>
			<td><?php echo $banner['description'];?></td>
			<td><?php echo $banner['continent_code'];?></td>
			<td><?php echo $banner['country_code'];?></td>
			<td><?php echo $banner['province_code'];?></td>
			<td><?php echo $banner['banner_type_id'];?></td>
			<td><?php echo $banner['active'];?></td>
			<td><?php echo $banner['destination_url'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'banners', 'action' => 'view', $banner['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'banners', 'action' => 'edit', $banner['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'banners', 'action' => 'delete', $banner['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $banner['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
