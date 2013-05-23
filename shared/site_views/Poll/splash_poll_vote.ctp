<script>
jQuery(document).ready(function($) {
	
	$('.voting-option').bind('click',function() { 

			

	});

	$("#PollVotingRecordForm").submit(function() { 

		$(".vote-button-div button").attr('disabled',true);

		return true;
	});

});
</script>
<style>
.voting-option {


	font-size:32px;
	color:#fff;
	margin-bottom:10px;
	border:1px solid #999;
	cursor: pointer;
	height:40px;
	line-height: 44px;
}

.voting-option label {

	width:100%;
	height:100%;
	line-height: 44px;
	font-size:32px;
	cursor:pointer;
	text-indent: 15px;
}

.voting-option:hover {

	background-color:#333;

}
.user-div {

	color:#fff;
	text-align: center;
}

.user-div a {

	color:#fff;

}

.vote-button-div {

	text-align: center;
	padding:20px;

}
</style>
<?php echo $this->Form->create('PollVotingRecord',array(
	"id"=>'PollVotingRecordForm',
	"url"=>"/poll/splash_handle_vote"
)); 

echo $this->Form->input("poll_id",array("value"=>$poll['Poll']['id'],"type"=>"hidden"));

?>
<div class='poll-heading'>
	<h1>POLL</h1>
</div>
<div id="poll-description">
	<?php echo $poll['Poll']['description']; ?>
</div>
<div id="voting-options">
	<?php foreach ($poll['PollVotingOption'] as $k => $v): ?>
		<div class='voting-option'>
			<label><input type="radio" name="data[PollVotingRecord][poll_voting_option_id]" value="<?php echo $v['id']; ?>" placeholder=""> <?php echo $v['name']; ?></label>
		</div>
	<?php endforeach ?>
</div>
<div class="vote-button-div">
	<button class="btn">Place Your Vote</button>
</div>
<div class="user-div">
	<?php if (CakeSession::check("Auth.User.id")): ?>
	You are logged in as <?php echo CakeSession::read('Auth.User.email'); ?> and are eligible to win the random mystery prize!
<?php else: ?>
	<a href='/identity/login/form/<?php echo base64_encode("/"); ?>'>Click here to sign in and be entered to win a random mystery prize!</a>
<?php endif ?>
<?php echo $this->Form->end(); ?>
</div>
