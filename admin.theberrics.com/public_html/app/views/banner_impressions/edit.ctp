<div class="bannerImpressions form">
<?php echo $this->Form->create('BannerImpression');?>
	<fieldset>
 		<legend><?php __('Edit Banner Impression'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('banner_id');
		echo $this->Form->input('banner_type_id');
		echo $this->Form->input('banner_placement_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('BannerImpression.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('BannerImpression.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Banner Impressions', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Types', true), array('controller' => 'banner_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Type', true), array('controller' => 'banner_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Placements', true), array('controller' => 'banner_placements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Placement', true), array('controller' => 'banner_placements', 'action' => 'add')); ?> </li>
	</ul>
</div>