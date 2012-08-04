<script>
$(document).ready(function() { 
	$("#identity-form form").ajaxForm({

		"success":function(d) {
			console.log(d);

			$("#identity-form form input[type=submit]").attr("disabled",false);

			if(d['url']) {

				document.location.href = d['url'];

			} else {

				alert(d['error']);
					
			}
			
		},
		"beforeSubmit":function() { 

			$("#identity-form form input[type=submit]").attr("disabled",true);
	
			return true;
		},
		"type":"post",
		"dataType":"json"
	});

	$("#UserEmail").get(0).focus;
	
});
</script>
<div id='identity-form'>
	<div>
		<h2>Sign in to The Berrics</h2>
	</div>
	<div>
		<a href='/identity/login/send_to_facebook' rel='no-ajax'>
			<img border='0' src='/img/login/facebook.png' />
		</a>
	</div>
	<div class='email-login'>
		<div class='inner'>
			<?php 
				echo $this->Session->flash();
				echo $this->Form->create("User",array("url"=>"/identity/login/form","rel"=>"no-ajax"));
				echo $this->Form->input("email");
				echo $this->Form->input("passwd",array("label"=>"Password","value"=>""));
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
	<div>
		<a href='/identity/login/reset_password'>Click here if you forgor your password</a>
	</div>
</div>