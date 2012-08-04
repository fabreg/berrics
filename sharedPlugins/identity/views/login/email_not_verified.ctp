<style>

#identity-email-not-verified {
	
	font-family:'Courier';
	-webkit-border-radius: 8px;
	border-radius: 8px;
	padding:10px;
	border:1px solid #666;
	background-color:#333;
	
}

</style>
<div id='identity-email-not-verified'>
<p>
<?php echo $user['User']['first_name']; ?>,
</p>
<p>
Your email address has not been verified.
</p>
<p>
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
</p>

</div>