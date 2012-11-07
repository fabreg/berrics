<?php 
$tag_array = Set::extract("/Tag/name",$this->data);
//die(pr($this->data));
$tag_str = implode(",",$tag_array);

?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	
	$('.tabbable li:eq(0) a').tab('show');

});

</script>
<style type='text/css'>
.user-profile-img-thumb {

	float:left; 
	margin:5px;
	text-align:center;
	border:1px solid #ccc;
	padding:3px;
}

.user-profile-img-thumb .submit input[type=submit] {

	font-size:12px;
	padding:5px;

}
</style>
<div class="page-header">
	<h1>Edit User</h1>
</div>
<?php echo $this->Form->create('User',array("url"=>$this->here,"enctype"=>"multipart/form-data"));?>
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li><a href="#1" data-toggle="tab">General</a></li>
		<li><a href="#2" data-toggle="tab">Social Networking</a></li>
		<li><a href="#3" data-toggle="tab">Profile</a></li>
		<li><a href="#4" data-toggle="tab">Contact Info</a></li>
		<li><a href="#5" data-toggle="tab">System Data</a></li>
	</ul>
	<div class="tab-content">
		<!-- General Info -->
		<div class="tab-pane active" id="1">
			<h3>General</h3>
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
				echo $this->Form->input("email_verified");
				echo $this->Form->input("first_name");
				echo $this->Form->input("last_name");
				echo $this->Form->input("email");
				echo $this->Form->input("berrics_employee");
				echo $this->Form->input("pro_skater");
				echo $this->Form->input("am_skater");
				echo $this->Form->input("title");
				echo $this->Form->input('user_group_id');
				
				echo $this->Form->input("profile_uri",array("label"=>"Profile Uri <span>(Must end in .html)</span>"));

				
			?>
		</div>
		<!-- Social Netowkring -->
		<div class="tab-pane" id="2">
			<h3>Social Networking</h3>
			<?php 
			
				echo $this->Form->input("twitter_handle",array("label"=>"Twitter Handle ( Use @ symbol )"));
			
				echo $this->Form->input("instagram_handle");

				echo $this->Form->input("UserProfile.id");
				echo $this->Form->input("UserProfile.instagram_followers",array("disabled"=>true));
				echo $this->Form->submit("Refresh Instagram Data",array("name"=>"data[UpdateInstagramData]"));
			?>
		</div>
		<!-- Profile Info -->
		<div class="tab-pane" id="3">
			<h3>Profile Info</h3>
			<?php 
				echo $this->Form->input("tags",array("type"=>"text","label"=>"Tags ( Comma seperated )","value"=>$tag_str));
				echo $this->Form->input("birth_date",array("minYear"=>1940,"maxYear"=>2011));
				echo $this->Form->input("profile_image",array("type"=>"file"));
				echo $this->Form->submit("Update Image",array("name"=>"data[UpdateProfileImage]"));
				
			?>
			<?php 
				if(count($this->data['UserProfileImage'])<=0):
			?>
				<div>No Image Uploaded</div>
			<?php else: ?>
				<div style='padding:10px;'>
				<?php foreach($this->data['UserProfileImage'] as $img): ?>
				<div class='user-profile-img-thumb'>
					<?php echo $this->Media->profileThumb($img,array(
						"w"=>"100"
					));?>
					<?php 
					
						if(!$img['default']):
					
					?>
					<div><?php echo $this->Form->submit("Make Default",array("name"=>"data[MakeDefaultImage][{$img['id']}]")); ?></div>
					<?php endif; ?>
					<div><?php echo $this->Form->submit("Delete",array("name"=>"data[DeleteProfileImage][{$img['id']}]")); ?></div>
					
				</div>
				<?php endforeach; ?>
				<div style='clear:both;'></div>
				</div>
			<?php endif; ?>
		</div>
		<!-- Contact Info -->
		<div class="tab-pane" id="4">
			<?php 
				echo $this->Form->input("phone_number");
				echo $this->Form->input("street_address");
				echo $this->Form->input("country",array("options"=>Arr::countries()));
			?>
		</div>
		<!-- System Info -->
		<div class="tab-pane" id="5">
			<h3>System Info</h3>
			<?php 
			
				echo $this->Form->input("profile_theme",array("options"=>array("profile"=>"Standard")));
				echo $this->Form->input("twitter_url");
				echo $this->Form->input("facebook_url");
				echo $this->Form->input('facebook_oauth_key');
				echo $this->Form->input('facebook_oauth_secret');
				echo $this->Form->input('facebook_account_num');
				echo $this->Form->input("profile_image_url",array("label"=>"Profile Image Url ( Facebook )"));
				echo $this->Form->input('twitter_oauth_key');
				echo $this->Form->input('twitter_oauth_secret');
				echo $this->Form->input('twitter_account_num');
				echo $this->Form->input('instagram_account_num',array("disabled"=>true));
				echo $this->Form->input("instagram_profile_image",array("disabled"=>true));
				
			?>
		</div>
	</div>
	<!-- end tab group -->
</div>
<div class="form-actions">
	<button class="btn btn-primary">
		<i class="icon icon-edit icon-white"></i> Update
	</button>
</div>
<?php echo $this->Form->end();?>