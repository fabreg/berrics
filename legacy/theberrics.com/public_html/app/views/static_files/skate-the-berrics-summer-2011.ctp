
<style>
	
.skate-the-berrics {

	background-color:#eceaea;
	color:black;
	padding:5px;
}

</style>
<div class='skate-the-berrics'>
	<div style='text-align:center;'>
		<img src='/img/splash/westchester/sk8-the-berrics.jpg' />
	</div>
	
	<?php 
		App::import("Model","User");
		$userModel = new User();
		$user = $userModel->find("first",array(
			"conditions"=>array(
				"User.id"=>
			),
			"contain"=>array(
				"UserProfile"
			)
		));
		if($this->Session->check("Auth.User.id")):
		
	?>
	
	<?php 
		else:
	?>
		<div class='sign-in'>
			<div>
				<p>
					Get Your Confirmation Number
				</p>
			</div>
			<div style='text-align:center; padding:10px;'>
				<a href='/identity/login/send_to_facebook/<?php echo base64_encode("/static_files/skatepark_confirmation"); ?>'>
					<img src='/img/login/facebook.png' border='0'/>
				</a>
			</div>
		</div>
	<?php 
		endif;
	?>
	
	
</div>