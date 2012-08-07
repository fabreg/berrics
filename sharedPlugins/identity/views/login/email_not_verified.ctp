<style>
#BerricsLogin .wrapper {

	width:600px;

}

</style>
<div id='identity-email-not-verified' class='identity-container'>
<div class='heading'>
	YO' EMAIL IS NOT VERIFIED
</div>
<p>
<?php echo $user['User']['first_name']; ?>,
</p>
<p>
Your email address has not been verified.
</p>
<div class='resend-link'>
<?php 

$str = "Click here to have your verificaton email resent to {$user['User']['email']}";

echo $this->Html->link($str,array(
							"plugin"=>"identity",
							"controller"=>"login",
							"action"=>"resend_verification",
							$user['User']['id'],
							$user['User']['account_hash']
						));

?>
</div>

</div>