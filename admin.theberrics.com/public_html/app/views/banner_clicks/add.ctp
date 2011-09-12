<div class="bannerClicks form">
<?php echo $this->Form->create('BannerClick');?>
	<fieldset>
 		<legend><?php __('Add Banner Click'); ?></legend>
	<?php
		echo $this->Form->input('banner_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Banner Clicks', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
	</ul>
</div>