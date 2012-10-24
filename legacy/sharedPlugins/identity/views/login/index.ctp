<?php



?>
<style>

	#login-wrapper {
	
	}
	
	#login-wrapper #login-buttons {
	
	
		width:50%;
		margin:auto;
	
	}
	
	#facebook-button {
	
		text-align:center;
	
	}
	
	
	#berrics-email {
	
		-moz-border-radius: 10px;
		border-radius: 10px;
		-webkit-box-shadow: 0px 5px 5px #757375;
		-moz-box-shadow: 0px 5px 5px #757375;
		box-shadow: 0px 5px 5px #757375;
		border:1px solid #999999;
		width:350px;
		margin:auto;
		
	}
	
	#berrics-email .berrics-email-header {
	
		text-align:center;
	
	}
	
	label {
	
		width:175px;
		display:block;
	
	}
	
	div.text,div.password {
	
		width:90%;
		margin:auto;
	
	}
	
	div input {
	
		width:99%;
	
	}
	
	.submit {
	
		width:50%;
		margin:auto;
		padding:10px;
	
	}
	
</style>

<?php 


$this->Html->css("login-form","stylesheet",array("inline"=>false));


?>

<div id='login-wrapper'>
	<?php 
	
		echo $this->element("login/login-message");
	
	
	?>
	<div id='login-buttons'>
		<div id='facebook-button'>		
			<a href='/identity/login/send_to_facebook/'>
				<img src='/img/login/facebook.png' border='0' />
			</a>
		</div>
		<div id='twitter-button'></div>
		<div id='berrics-email'>
			<div class='berrics-email-header'>Login with your email and password</div>
			<?php 
			
				echo $this->Form->create("User",array("url"=>"/identity/login/email_login/"));
				echo $this->Form->input("email");
				echo $this->Form->input("passwd",array("label"=>"Password")); 
				echo $this->Form->end("Login");
			
			?>
		</div>
	</div>
</div>
<?php 

pr($this->Session->read());


?>