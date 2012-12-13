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
<style type='text/css'>
#BerricsLogin .wrapper {

	width:680px;
	

}
</style>
<?php if ($this->request->is('ajax')): ?>
<div class="modal-header">
	<h3>Login to The Berrics</h3>
</div>
<div class="modal-body">
<?php endif ?>
<div id='identity-form' class='identity-container'>
	<?php if (!$this->request->is('ajax')): ?>
	<div class='heading'>
		SIGN IN TO THE BERRICS
	</div>
	<?php endif ?>
	<div class='social-connect-buttons'>
		<a href='/identity/login/send_to_facebook' rel='no-ajax'>
			<img border='0' src='/img/layout/login/fb-connect-grey.png' />
		</a>
	</div>
	<div class='or-div'>
		-or-
	</div>
	<div class='email-login'>
		<div class='inner'>
			<?php 
				echo $this->Session->flash();
				echo $this->Form->create("User",array("url"=>"/identity/login/form","rel"=>"no-ajax"));
				echo $this->Form->input("email",array("label"=>"Email Address:"));
				echo $this->Form->input("passwd",array("label"=>"Password:","value"=>""));
			?>
			<div class='reset-password-link'>
						<a href='/identity/login/reset_password'>Forgot Your Password?</a>
			</div>
			<?php echo $this->Form->submit("SIGN IN"); ?>
			<?php	
			
				echo $this->Form->end();
				
			?>
		</div>
	</div>

	<div class='register-link'>
		Not Registered? <a href='/identity/login/register' rel='register-link'>
			Click Here To Create An Account
		</a>
	</div>
</div>
<?php if ($this->request->is('ajax')): ?>
</div>
<div class="modal-footer">
	
</div>
<?php endif ?>