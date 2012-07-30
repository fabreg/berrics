<script>
$(document).ready(function() { 


	<?php if($this->params['isAjax']): ?>
	$("a[rel=register-link]").click(function() { 

		$.BerricsLogin('openWindow',{
			"screen":'registerScreen'	
		});

		return false;
		
	});
	<?php endif; ?>

	
});
</script>
<div id='identity-form'>
	<div>
		<h2>Sign in to The Berrics</h2>
	</div>
	<div>
		<a href='/identity/login/send_to_facebook'>
			<img border='0' src='/img/login/facebook.png' />
		</a>
	</div>
	<div class='email-login'>
		<div class='inner'>
			<?php 
			
				echo $this->Form->create("User",array("url"=>array("action"=>"email_login","controller"=>"login")));
				echo $this->Form->input("email");
				echo $this->Form->input("passwd");
				echo $this->Form->end("Login");
				
			?>
		</div>
	</div>
	<div>
		OR
	</div>
	<div>
		<a href='/identity/login/register' rel='register-link'>
			Click Here to register an account
		</a>
	</div>
</div>