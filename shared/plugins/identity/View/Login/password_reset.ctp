<script>

$(document).ready(function() { 


	$("#back-button").click(function() { 

		document.location.href='/dailyops';

	});

	
});

</script>
<div id='identity-password-reset' class='identity-container'>
<h1>
	PASSWORD RESET
</h1>
<?php if($record['UserPasswdReset']['active']==1): ?>
<?php echo $this->Session->flash(); ?>
<div class='reset-form'>
<?php 

echo $this->Form->create("User",array("url"=>$this->here));
echo $this->Form->input("new_passwd",array("label"=>"New Password","type"=>"password"));
echo $this->Form->input("passwd_confirm",array("type"=>"password","label"=>"Confirm New Password"));
echo $this->Form->end("Reset Password");

?>
</div>
<?php else: ?>
<p style='text-align:center; padding:10px;'>Your password has been reset successfully</p>
<div class='reset-link' style='text-align:center;'>
	<a href='/dailyops' class='btn'>GO TO THE DAILY OPS</a> 
	&nbsp;&nbsp;&nbsp;&nbsp;
	<a href='/identity/login/form' class='btn'>CLICK HERE TO LOGIN</a>
</div>
<?php endif; ?>
</div>