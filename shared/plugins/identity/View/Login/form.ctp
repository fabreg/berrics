<script>
$(document).ready(function() { 
	
	$("#UserEmail").get(0).focus();
	
});
</script>
<?php echo $this->Form->create("User",array("url"=>"/identity/login/form","rel"=>"no-ajax","class"=>"form modal-form")); ?>
<?php if ($this->request->is('ajax')): ?>
<div class="modal-header">
	<span class="close" style='float:right;' data-dismiss='modal'>x</span>
	<h4>Login to The Berrics </h4>
</div>
<div class="modal-body">
<?php endif ?>
<div class="row-fluid" id='identity-form'>
	<div class="span12">
		<div class="inner">
			<?php if (!$this->request->is('ajax')): ?>
				<h3>Login to The Berrics</h3>
			<?php endif ?>
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
	<div class="inner" style='text-align:center;'>
		Not Registered? <a href='/identity/login/register' rel='register-link'>
			Click Here To Create An Account
		</a>
	</div>
</div>
<?php endif ?>
<?php	

	echo $this->Form->end();
	
?>