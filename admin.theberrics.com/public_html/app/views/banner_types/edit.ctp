<div class="bannerTypes form">
<?php echo $this->Form->create('BannerType');?>
	<fieldset>
 		<legend><?php __('Edit Banner Type'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('width');
		echo $this->Form->input('height');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('BannerType.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('BannerType.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Banner Types', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Banner Impressions', true), array('controller' => 'banner_impressions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Impression', true), array('controller' => 'banner_impressions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Placements', true), array('controller' => 'banner_placements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Placement', true), array('controller' => 'banner_placements', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
	</ul>
</div>