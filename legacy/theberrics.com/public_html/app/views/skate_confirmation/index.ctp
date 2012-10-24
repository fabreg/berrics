
<style>
	
.skate-the-berrics {

	background-color:#eceaea;
	color:black;
	padding:5px;
}
.conf {

	font-size:19px;
	font-family:Arial;
	line-height:28px;
	text-align:center;
}
.sign-in {

	font-size:24px;
	font-family:Arial;
	line-height:28px;
}

</style>
<div class='skate-the-berrics'>
	<div style='text-align:center;'>
		<img src='/img/splash/westchester/sk8-the-berrics.jpg' />
	</div>
	<div>
		<?php 
		
			if(!$user) {
				
				echo $this->element("skate_confirmation/login");
				
			} else {
				if($user['UserProfile']['westchester_confirmation'] == 1) {
					
					echo $this->element("skate_confirmation/conf");
					
				} else {
					
					echo $this->element("skate_confirmation/login");
					
				}
				
				
			}
		?>
	</div>
</div>