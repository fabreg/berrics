<?php 

$year_drop = array();

for($i=2012;$i>=1975;$i--) $year_drop[$i]=$i;

$good = array(
		
			"I suck",
			"I suck really bad",
			"I have my moments",
			"I'm aight, I'm aight!",
			"Koston Steeze",
			"I'm sponsored, OF COURSE I KILL IT!",
			"My video part will be on youtube soon and you'll see",
			
		);

?>
<script>
$(document).ready(function() { 

	
	
});
</script>
<style>
#BerricsLogin .wrapper {

	width:750px;
	

}
</style>
<div id='identity-register' class='identity-container'>
<div class='heading'>
	THE BERRICS REGISTRATION FORM
</div>
<?php echo $this->Session->flash(); ?>
<?php echo $this->Form->create("User",array("url"=>$this->here,"id"=>"identity-register-form")); ?>
	<div class='required-fields'>
		<div class='form-heading'>Required Information</div>
		<?php 
					echo $this->Form->input("User.first_name");
					echo $this->Form->input("User.last_name");
					echo $this->Form->input("User.email");
					echo $this->Form->input("new_passwd",array("label"=>"Password","type"=>"password"));
					echo $this->Form->input("new_passwd_confirm",array("label"=>"Confirm Password","type"=>"password"));
					echo $this->Form->input("country",array("options"=>Arr::countries()));
					echo $this->Form->input("city");
		?>
	</div>
	<div class='optional-fields'>
		<div class='form-heading'>Optional Skate Information</div>
		<?php 
				
				echo $this->Form->input("UserProfile.stance",array("options"=>User::stanceSelect()));
				echo $this->Form->input("UserProfile.year_skating",array("label"=>"When Did You Start","options"=>$year_drop,"empty"=>true));
				echo $this->Form->input("UserProfile.shirt_size");
				echo $this->Form->input("UserProfile.shoe_size");
				//echo $this->Form->input("UserProfile.are_you_good",array("options"=>$good,"label"=>"Are you good?","empty"=>true));			
			
			?>
	</div>
	<div style='clear:both;'></div>
<?php echo $this->Form->end("REGISTER ACCOUNT"); ?>
</div>