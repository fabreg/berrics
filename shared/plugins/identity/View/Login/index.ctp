<?php



?>
<style>

	#login-wrapper {
	
	}
	
	#login-wrapper #login-buttons {
	
	
		width:50%;		margin:auto;
	
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

<div class='row-fluid'>
	<div class='span4'></div>
	<div class='span4 well'>
		<div class='row-fluid'>
			<h3>Login via email</h3>
			<?php 
					$this->Form->formSpan = "span11";
					echo $this->Form->create("User",array(
													"url"=>"/identity/login/email_login/",
												
											));
					echo $this->Form->input("email",array(
												"prepend"=>"<i class='icon-envelope'></i>"
											));
					echo $this->Form->input("passwd",array("label"=>"Password","prepend"=>"<i class='icon-lock'></i>")); 
				
					?>
					<div class='form-actions' style=''>
						<button class='btn btn-primary' type='submit'>Login</button>
					</div>
					<?php 
					echo $this->Form->end();
				
				?>
				<div class='form-actions'>
					<div id='facebook-button'>		
						<a href='/identity/login/send_to_facebook/'>
							<img src='/img/login/facebook.png' border='0' />
						</a>
					</div>
				</div>
		</div>
			
	
	</div>
	<div class='span4'></div>
</div>


<?php 
CakeSession::write("Testing","FUCK");
pr($this->Session->read());


?>