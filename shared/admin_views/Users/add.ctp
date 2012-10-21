<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Add User'); ?></legend>
	<?php
		echo $this->Form->input("first_name");
		echo $this->Form->input("last_name");
		echo $this->Form->input("email");
		echo $this->Form->input("passwd");
		echo $this->Form->input('user_group_id');
		echo $this->Form->input("tags",array("label"=>"Tags: (Multiple tags should be comma seperated)"));
	?>
	</fieldset>
		
	<fieldset>
		<legend>Contact Information</legend>
		<?php 
			echo $this->Form->input("birth_date",array("minYear"=>1970,"maxYear"=>2011));
			echo $this->Form->input("phone_number");
			echo $this->Form->input("street_address");
			echo $this->Form->input("country",array("options"=>Arr::countries()));
		?>
	</fieldset>
	
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('List Users', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List User Groups', true), array('controller' => 'user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User Group', true), array('controller' => 'user_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Dailyops', true), array('controller' => 'dailyops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Dailyop', true), array('controller' => 'dailyops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Media Files', true), array('controller' => 'media_files', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Media File', true), array('controller' => 'media_files', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List User Permissions', true), array('controller' => 'user_permissions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User Permission', true), array('controller' => 'user_permissions', 'action' => 'add')); ?> </li>
	</ul>
</div>