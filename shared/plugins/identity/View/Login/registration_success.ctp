<style>
#BerricsLogin .wrapper {

	width:700px;

}
</style>
<script>

$(document).ready(function() { 


	$("#identity-register-success #login-button").bind("click",function(e) { 

		$.BerricsLogin('openWindow',"/identity/login/form");
		
	});
	
	
});


</script>
<div id='identity-register-success' class='identity-container'>
<div class='heading'>
	CHECK YO' EMAIL
</div>
<p>
<?php echo ucfirst($user['User']['first_name']); ?>,
</p>
<p>
&nbsp;&nbsp;A verification email has been sent to: <strong><?php echo $user['User']['email']?></strong>
</p>
<p>
Please allow a few minutes for it to reach you. Also, check your junk email folder 
and then add theberrics.com to your safe listfor future correspondence.
</p>
<div class='login-button'>
	<input type='button' value='CLICK HERE TO SIGN IN' id='login-button'/>
</div>
</div>