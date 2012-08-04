<style>
#identity-verification-resent {

	font-family:'Courier';
	-webkit-border-radius: 8px;
	border-radius: 8px;
	padding:10px;
	border:1px solid #666;
	background-color:#333;

}


</style>
<div id='identity-verification-resent'>
<p>
	<?php echo $user['User']['first_name']; ?>,
</p>
<p>
A verification email has been resent to: <?php echo $user['User']['email']; ?>
</p>
<p>
Please allow a few minute for it to reach you. Also, check your junk email folder and add theberrics.com to your safe list for future correspondence. 
</p>
</div>