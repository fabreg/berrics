<div class="userGroups form">
<?php echo $this->Form->create('UserGroup');?>
	<fieldset>
 		<legend><?php __('Add User Group'); ?></legend>
	<?php
		echo $this->Form->input("id",array("type"=>"text"));
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List User Groups', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List User Permissions', true), array('controller' => 'user_permissions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Permission', true), array('controller' => 'user_permissions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>