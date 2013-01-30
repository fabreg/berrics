<?php if(!$this->Session->check("Auth.User.id")): ?>
	<div class='facebook-login-large'>
		<a href='/identity/login/send_to_facebook/<?php echo base64_encode($this->here); ?>'><img src='/theme/younited-nations-3/img/yn3-facebook-large.jpg' alt='' border='0' /></a>
	</div>
<?php endif; ?>