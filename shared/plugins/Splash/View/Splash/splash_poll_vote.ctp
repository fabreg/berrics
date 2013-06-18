<script>
jQuery(document).ready(function($) {
	
	
	
	$('.voting-option input:eq(0)').trigger('click');

	initRadios();

	$('.voting-option input').bind('change',function() { 

			initRadios()

	});

	$("#PollVotingRecordForm").submit(function() { 

		$(".vote-button-div button").attr('disabled',true);

		return true;
	});

});

function initRadios() {

	$('input[type=radio]').each(function() { 

		var $parent = $(this).parent();

		var $check = $parent.find('.checkbox');
	
		if($(this).is(":checked")) {

			$check.find('img').attr({

				src:'/img/v3/poll/checked.png'

			});			

		} else {

			$check.find('img').attr({

				src:'/img/v3/poll/unchecked.png'

			});	

		}

	});

}
</script>
<style>
.voting-option {


	font-size:32px;
	color:#fff;
	margin-bottom:18px;
	
	cursor: pointer;
	height:40px;
	line-height: 44px;
	
}

.voting-option label {

	width:100%;
	height:100%;
	line-height: 32px;
	font-size:32px;
	cursor:pointer;
	text-align: center;

}

.voting-option input {

	display: none;

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

.checkbox {

	
}

.checkbox img {

	margin-top:-18px;

}

</style>
<?php echo $this->Form->create('PollVotingRecord',array(
	"id"=>'PollVotingRecordForm',
	"url"=>"/splash/splash_handle_vote"
)); 

echo $this->Form->input("poll_id",array("value"=>$poll['Poll']['id'],"type"=>"hidden"));

?>
<div class='poll-heading'>

</div>
<div id="poll-description">
	<?php echo $poll['Poll']['description']; ?>
</div>
<div id="voting-options">
	<?php foreach ($poll['PollVotingOption'] as $k => $v): ?>
		<div class='voting-option'>
			<label><span class='checkbox'><img src="/img/v3/poll/unchecked.png" alt=""></span><input type="radio" name="data[PollVotingRecord][poll_voting_option_id]" value="<?php echo $v['id']; ?>" placeholder=""> <?php echo $v['name']; ?></label>
		</div>
	<?php endforeach ?>
</div>
<div class="vote-button-div">
	<button class="btn btn-success btn-large">Place Your Vote</button>
</div>
<div class="user-div">
	<?php if (CakeSession::check("Auth.User.id")): ?>
	You are logged in as <?php echo CakeSession::read('Auth.User.email'); ?> and are eligible to win the random mystery prize!
<?php else: ?>
	<a href='/identity/login/form/<?php echo base64_encode("/"); ?>'>Click here to sign in and be entered to win a random mystery prize!</a>
<?php endif ?>
<?php echo $this->Form->end(); ?>
</div>
