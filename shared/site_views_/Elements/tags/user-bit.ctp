<?php

$this->Html->css("tags/index","stylesheet",array("inline"=>false));


?>

<div class='user-bit'>
	<div class='profile-image'>
		<img src='<?php echo $user['profile_image_url']; ?>' />
	</div>
	<div class='user-info'>
		<?php 
			
			echo $this->Html->link($user['first_name']." ".$user['last_name'],array("controller"=>"profiles","action"=>"view",$user['id']));
		
		?>
	
	</div>
</div>