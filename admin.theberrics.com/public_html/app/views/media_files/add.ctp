<div class="mediaFiles form">
<?php echo $this->Form->create('MediaFile');?>
	<fieldset>
 		<legend><?php __('Add Media File'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('user_id');
		echo $this->Form->input('media_type');
		echo $this->Form->input('legacy_id');
		echo $this->Form->input('Dailyop');
		echo $this->Form->input('Tag');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Media Files', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media File Users', true), array('controller' => 'media_file_users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media File User', true), array('controller' => 'media_file_users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media File Views', true), array('controller' => 'media_file_views', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media File View', true), array('controller' => 'media_file_views', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dailyops', true), array('controller' => 'dailyops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dailyop', true), array('controller' => 'dailyops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags', true), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag', true), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>