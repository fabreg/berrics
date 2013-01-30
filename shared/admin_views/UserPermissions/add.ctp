<div class="userPermissions form">
<?php echo $this->Form->create('UserPermission');?>
	<fieldset>
 		<legend><?php echo __('Add User Permission'); ?></legend>
	<?php
		echo $this->Form->input('app_name');
		echo $this->Form->input('controller');
		echo $this->Form->input('action');
		echo $this->Form->input('user_group_id');
		echo $this->Form->input("allowed");
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link(__('List User Permissions'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List User Groups'), array('controller' => 'user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User Group'), array('controller' => 'user_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>