<?php 
$tag_array = Set::extract("/Tag/name",$this->data);
//die(pr($this->data));
$tag_str = implode(",",$tag_array);

?>
<div class="users form">
<?php echo $this->Form->create('User',array("url"=>$this->here,"enctype"=>"multipart/form-data"));?>
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
		echo $this->Form->input("berrics_employee");
		echo $this->Form->input("pro_skater");
		echo $this->Form->input("am_skater");
		echo $this->Form->input("title");
		echo $this->Form->input('user_group_id');
		echo $this->Form->input("birth_date",array("minYear"=>1940,"maxYear"=>2011));
		echo $this->Form->input("profile_uri",array("label"=>"Profile Uri <span>(Must end in .html)</span>"));
		echo $this->Form->input("profile_image_url");
		echo $this->Form->input("tags",array("type"=>"text","label"=>"Tags ( Comma seperated )","value"=>$tag_str));
		echo $this->Form->input("profile_theme",array("options"=>array("profile"=>"Standard")));
		echo $this->Form->submit("Update"); 
	?>
	</fieldset>
	<fieldset>
		<legend>Profile Image</legend>
		<?php 
		
			echo $this->Form->input("profile_image",array("type"=>"file"));
			echo $this->Form->submit("Update Image",array("name"=>"data[UpdateProfileImage]"));
			
		?>
		<?php 
			if(empty($this->data['User']['profile_img_file'])):
		?>
			<div>No Image Uploaded</div>
		<?php else: ?>
			<div style='padding:10px;'>
			<?php echo $this->Media->profileThumb($this->data['User'],array(
				"w"=>"100"
			)); ?>
			</div>
		<?php endif; ?>
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
		<legend>Profile</legend>
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