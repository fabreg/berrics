<?php 
$tag_array = Set::extract("/Tag/name",$this->data);
//die(pr($this->data));
$tag_str = implode(",",$tag_array);

?>
<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit User'); ?></legend>
 		<?php 
 		
 			if($this->data['User']['user_group_id'] == 10):
 		
 		?>
 		<div>
 			Dailyops Calendar URL: http://admin.theberrics.com/theberrics.ics?a=<?php echo $this->data['User']['ical_hash']; ?>
 		</div>
 		<?php 
 		
 			endif;
 		
 		?>
	<?php
		
		
		echo $this->Form->input('id');
		echo $this->Form->input("first_name");
		echo $this->Form->input("last_name");
		echo $this->Form->input("email");
		echo $this->Form->input("title");
		echo $this->Form->input('user_group_id');
		echo $this->Form->input("birth_date",array("minYear"=>1970,"maxYear"=>2011));
		echo $this->Form->input("profile_image_url");
		echo $this->Form->input("tags",array("type"=>"text","label"=>"Tags ( Comma seperated )","value"=>$tag_str));
		
	?>
	</fieldset>
	
	<fieldset>
		<legend>Contact Information</legend>
		<?php 
		
			echo $this->Form->input("phone_number");
			echo $this->Form->input("street_address");
			echo $this->Form->input("country",array("options"=>Arr::countries()));
		?>
	</fieldset>
	
	<fieldset>
		<legend>Social Network Stuff</legend>
		<?php 
		
			echo $this->Form->input("twitter_handle",array("label"=>"Twitter Handle ( Use @ symbol )"));
		
			echo $this->Form->input("instagram_handle");
			
			echo $this->Form->input("twitter_url");

			echo $this->Form->input("facebook_url");
			
			
			

		?>
	</fieldset>
	<fieldset>
		<legend>Social Networking BACKEND STUFF</legend>
		<?php 
		
			echo $this->Form->input('facebook_oauth_key');
			echo $this->Form->input('facebook_oauth_secret');
			echo $this->Form->input('facebook_account_num');
			echo $this->Form->input('twitter_oauth_key');
			echo $this->Form->input('twitter_oauth_secret');
			echo $this->Form->input('twitter_account_num');
			
		
		?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List User Groups', true), array('controller' => 'user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Group', true), array('controller' => 'user_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dailyops', true), array('controller' => 'dailyops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dailyop', true), array('controller' => 'dailyops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media Files', true), array('controller' => 'media_files', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media File', true), array('controller' => 'media_files', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Permissions', true), array('controller' => 'user_permissions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Permission', true), array('controller' => 'user_permissions', 'action' => 'add')); ?> </li>
	</ul>
</div>