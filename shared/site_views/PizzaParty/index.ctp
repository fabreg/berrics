<style>

#contest {


	font-size:22px;

	padding:15px;
	
}

</style>
<?php 

if($user):

?>

<div id='contest'>
CONGRATULATIONS<br /><br />
YOU HAVE BEEN ENTERED IN THE DANNY WAY DRAWING <br />
If you are selected. We will send an email to the address listed below on December 12th 2012 with further details<br /><br />
<?php echo $user['User']['email']; ?> <br /><br />
<a href='/dailyops'>Back to the Daily Ops</a>
</div>
<?php 

else:

?>
<div id='contest'>
SORRY THERE WAS A PROBLEM: <br />
YOU NEED TO ENTER AND SHARE YOUR LOCATION INFORMATION ON FACEBOOK TO BE ELIGIBALE <br />
PLEASE UPDATE YOUR LOCATION IN FACEBOOK AND TRY AGAIN. <br />
</div>

<img src='/img/facebook-profile.png' />
<?php 

endif;

?>
