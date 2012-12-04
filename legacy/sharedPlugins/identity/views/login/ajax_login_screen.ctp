<script>
$(document).ready(function() { 

	$("#register-button").click(function() { 

		$.BerricsLogin("openWindow",{
			"screen":"registerScreen"
		});

	});
	
});
</script>
<div class="modal-header"></div>
<div class="modal-body">
	<div class='login-screen'>

	<a href='javascript:$.BerricsLogin("closeWindow"); '>CLOSE</a>
		<div class='facebook-connect'>
			<a href='/identity/login/send_to_facebook'><img border='0' src='/img/login/facebook.png' /></a>
		</div>
		<div>
			<span id='register-button'>Register an account</span>
		</div>
	</div>
</div>
<div class="modal-footer">
	
</div>