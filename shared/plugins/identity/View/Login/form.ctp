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
<?php echo $this->Form->create("User",array("url"=>"/identity/login/form","rel"=>"no-ajax","class"=>"form modal-form")); ?>
<?php if ($this->request->is('ajax')): ?>
<div class="modal-header">
	<h4>Login to The Berrics</h4>
</div>
<div class="modal-body">
<?php endif ?>
<div class="row-fluid" id='identity-form'>
	<div class="span12">
		<div class="inner">
			<div class="social-network-logins">
				<a href='/identity/login/send_to_facebook' rel='no-ajax'>
					<img border='0' src='/img/layout/login/fb-connect-grey.png' />
				</a>
				<div>- OR -</div>
			</div>
			<?php 
				echo $this->Session->flash();
				echo $this->Form->input("email",array("label"=>"Email Address:"));
				echo $this->Form->input("passwd",array("label"=>"Password:","value"=>""));
			?>
			<div class="email-submit-div clearfix">
				<button type='submit' class='btn'>Login</button>
				<div class='reset-password-link'>
					<a href='/identity/login/reset_password'>Forgot Your Password?</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if ($this->request->is('ajax')): ?>
</div>
<div class="modal-footer">
	
</div>
<?php endif ?>
<?php	

	echo $this->Form->end();
	
?>