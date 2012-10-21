<div class="userGroups form">
<?php echo $this->Form->create('UserGroup');?>
	<fieldset>
 		<legend><?php echo __('Edit User Group'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $this->Form->value('UserGroup.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('UserGroup.id'))); ?></li>
		<li><?php echo $this->Admin->link(__('List User Groups'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List User Permissions'), array('controller' => 'user_permissions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User Permission'), array('controller' => 'user_permissions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>