<div class='day'>
	DAY <?php echo $winner['UserContestEntry']['winning_rank']; ?> WINNER
</div>
<!-- 
<div class='facebook-img'>
	<img src='<?php echo $winner['User']['profile_image_url']; ?>' border='' alt='' />
</div>
-->
<div class='name'>
	<a href='http://facebook.com/profile.php?id=<?php echo $winner['User']['facebook_account_num']; ?>' target='_blank'><?php echo $winner['User']['first_name']." ".$winner['User']['last_name']; ?></a>
</div>
