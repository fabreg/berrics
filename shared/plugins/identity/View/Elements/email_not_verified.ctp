<div>
<p>
<?php echo $user['User']['first_name']; ?>,
</p>
<p>
Your email address has not been verified.
</p>
<p>
<?php 

$str = "Click here to have your confirmation email resent to {$user['User']['email']}";

echo $this->Html->link($str,array(
							"plugin"=>"identity",
							"controller"=>"login",
							"action"=>"resend_confirmation",
							$user['User']['id'],
							$user['User']['account_hash']
						));

?>
</p>

</div>