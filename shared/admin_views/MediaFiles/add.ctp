<div class="mediaFiles form">
<?php echo $this->Form->create('MediaFile');?>
	<fieldset>
 		<legend><?php echo __('Add Media File'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('user_id');
		echo $this->Form->input('media_type');
		echo $this->Form->input('legacy_id');
		echo $this->Form->input('Dailyop');
		echo $this->Form->input('Tag');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('List Media Files'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Media File Users'), array('controller' => 'media_file_users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Media File User'), array('controller' => 'media_file_users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Media File Views'), array('controller' => 'media_file_views', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Media File View'), array('controller' => 'media_file_views', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Dailyops'), array('controller' => 'dailyops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Dailyop'), array('controller' => 'dailyops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Tags'), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>