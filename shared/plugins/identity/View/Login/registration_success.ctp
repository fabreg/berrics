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
<h2>
	CHECK YO' EMAIL
</h2>
<p>
<?php echo ucfirst($user['User']['first_name']); ?>,
</p>
<p>
&nbsp;&nbsp;A verification email has been sent to: <strong><?php echo $user['User']['email']?></strong>
</p>
<p>
Please allow a few minutes for it to reach you. Also, check your junk email folder 
and then add theberrics.com to your safe list for future correspondence.
</p>
<div class='login-button'>
	<a href="/identity/login/form" class="btn">CLICK HERE TO SIGN IN</a>
</div>
</div>