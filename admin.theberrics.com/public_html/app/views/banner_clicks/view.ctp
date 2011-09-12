<div class="bannerClicks view">
<h2><?php  __('Banner Click');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerClick['BannerClick']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerClick['BannerClick']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Banner'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($bannerClick['Banner']['id'], array('controller' => 'banners', 'action' => 'view', $bannerClick['Banner']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Banner Click', true), array('action' => 'edit', $bannerClick['BannerClick']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Banner Click', true), array('action' => 'delete', $bannerClick['BannerClick']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bannerClick['BannerClick']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Clicks', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Click', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
	</ul>
</div>
