<div class="bannerPlacements form">
<?php echo $this->Form->create('BannerPlacement');?>
	<fieldset>
 		<legend><?php __('Edit Banner Placement'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('banner_type_id');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('BannerPlacement.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('BannerPlacement.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Banner Placements', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Banner Types', true), array('controller' => 'banner_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Type', true), array('controller' => 'banner_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Impressions', true), array('controller' => 'banner_impressions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Impression', true), array('controller' => 'banner_impressions', 'action' => 'add')); ?> </li>
	</ul>
</div>