<div class="userGroups form">
<?php echo $this->Form->create('UserGroup');?>
	<fieldset>
 		<legend><?php echo __('Add User Group'); ?></legend>
	<?php
		echo $this->Form->input("id",array("type"=>"text"));
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('List User Groups'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List User Permissions'), array('controller' => 'user_permissions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User Permission'), array('controller' => 'user_permissions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>