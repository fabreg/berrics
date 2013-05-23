<div class="poll-header">
	<h1>Add Voting Option <small><?php echo $poll['Poll']['name']; ?></small></h1>
</div>
<div class="pollVotingOptions form">
<?php echo $this->Form->create('PollVotingOption'); ?>
	<?php
		if(isset($this->request->data['PollVotingOption']['id'])) {

			echo $this->Form->input("id");

		}
		echo $this->Form->input('name');
		echo $this->Form->input('display_weight');
		echo $this->Form->input("poll_id",array("value"=>$poll['Poll']['id'],"type"=>"hidden"));
	?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>