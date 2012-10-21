<div class="userPermissions form">
<?php echo $this->Form->create('UserPermission');?>
	<fieldset>
 		<legend><?php __('Edit User Permission'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('app_name');
		echo $this->Form->input('controller');
		echo $this->Form->input('action');
		echo $this->Form->input('user_group_id');
		echo $this->Form->input('user_id',array("empty"=>true));
		echo $this->Form->input("allowed");
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('UserPermission.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('UserPermission.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List User Permissions', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List User Groups', true), array('controller' => 'user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Group', true), array('controller' => 'user_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>