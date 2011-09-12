<?php


?>


<style>

#signup-form {

	

}

#signup-form .submit {

	padding:15px;
	text-align:center;


}

.signup-text {

	font-size:15px;

}





</style>
<?php 

if($this->Session->read("signup") != 1):

?>
<div id='signup-form' class='form'>
	<div class='signup-text'>
		THE FIRST 500...

We need 500 people to participate in a top secret photo shoot on Saturday March 5th, 2011
We're going to skate, we're going to eat IN n Out and we're going to take a picture.
<br /><br />
If you are in the first 500 to sign up you will also be invited to one of the 10 pizza parties the Berrics
will be throwing in celebration, and appreciation, of your participation. Got that? Good.
<br /><br />
<div style='text-align:center;'>Sign up below to be a part of history</div>
		<div style='text-align:center;'>
			Fill out the form below or <br />
			<a href='/send_to_facebook/'><img src='/img/fb-button.png' border='0' /></a>
		</div>
	</div>
	<?php 
	
		echo $this->Form->create("User",array("url"=>$this->here));
		echo $this->Form->input("first_name");
		echo $this->Form->input("last_name");
		echo $this->Form->input("email");
		echo $this->Form->end("Signup");
	
	?>
</div>
<?php endif; ?>