<div class="banners form">
<?php echo $this->Form->create('Banner');?>
	<fieldset>
 		<legend><?php __('Add Banner'); ?></legend>
	<?php
		echo $this->Form->input('file_name');
		echo $this->Form->input('user_id');
		echo $this->Form->input('description');
		echo $this->Form->input('continent_code');
		echo $this->Form->input('country_code');
		echo $this->Form->input('province_code');
		echo $this->Form->input('banner_type_id');
		echo $this->Form->input('active');
		echo $this->Form->input('destination_url');
		echo $this->Form->input('Tag');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Banners', true), array('action' => 'index'));?></li>
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