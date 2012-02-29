<style>

#contest {

	background-color:#000;
	color:#e9e9e9;
	font-size:22px;
	text-align:center;
	padding:15px;
	border:1px solid #999;
}

</style>
<?php 

if($user):

?>

<div id='contest'>
CONGRATULATIONS<br /><br />
YOU HAVE BEEN ENTERED IN THE MIKEMO CAPALDI DRAWING <br />
If you are selected. We will send an email to the address listed below on March 1st 2012 with further details<br /><br />
<?php echo $user['User']['email']; ?> <br /><br />
<a href='/dailyops'>Back to the Daily Ops</a>
</div>
<?php 

else:

?>
<div id='contest'>
SORRY THERE WAS A PROBLEM: <br />
YOU NEED TO ENTER IN YOUR LOCATION INFORMATION IN FACEBOOK TO BE ELIGIBALE <br />
PLEASE UPDATE YOUR LOCATION IN FACEBOOK AND TRY AGAIN. <br />
</div>

<img src='/img/facebook-profile.png' />
<?php 

endif;

?>
