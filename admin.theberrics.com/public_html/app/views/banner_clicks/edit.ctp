<div class="bannerClicks form">
<?php echo $this->Form->create('BannerClick');?>
	<fieldset>
 		<legend><?php __('Edit Banner Click'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('banner_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('BannerClick.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('BannerClick.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Banner Clicks', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
	</ul>
</div>