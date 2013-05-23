<script>
	jQuery(document).ready(function($) {
		
		$("#PollStartDate").datepicker({
				"dateFormat":"yy-mm-dd"
		});

		$("#PollEndDate").datepicker({
				"dateFormat":"yy-mm-dd"
		});


	});
</script>
<?php echo $this->Form->create('Poll',array(
	"id"=>'PollForm',
	"url"=>$this->request->here
)); ?>
<div class="page-header">
	<h1>Edit Poll</h1>
</div>
<div class="row-fluid">
	<div class="span6">
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('start_date',array("type"=>"text"));
			echo $this->Form->input('end_date',array("type"=>"text"));
			echo $this->Form->input('name');
			echo $this->Form->input('description');
			echo $this->Form->input('active');
			echo $this->Form->input('website_id');
		?>
	</div>
	<div class="span6">
		<h3>Poll Voting Options</h3>
		<div class="well well-small">
			<a href="<?php echo $this->Admin->url(array("controller"=>"poll_voting_options","action"=>"add",$this->request->data['Poll']['id'])); ?>" class="btn btn-success btn-mini">Add New Voting Option</a>
		</div>
		<?php if (count($this->request->data['PollVotingOption'])>0): ?>
			
				<table cellspacing="0">
					<tr>
						<th>Active</th>
						<th>Display Weight</th>
						
						<th>Name</th>
						<th>Media</th>
						<th>Options</th>
					</tr>
					<?php foreach ($this->request->data['PollVotingOption'] as $k => $v): ?>
					<tr>
						<td align='center'>
							<?php echo $this->Form->input("PollVotingOption.{$k}.active",array("label"=>false,'div'=>false)); ?>
						</td>
						<td>
							<?php echo $this->Form->input("PollVotingOption.{$k}.display_weight",array("label"=>false)); ?>
							<?php echo $this->Form->input("PollVotingOption.{$k}.id"); ?>
						</td>
						
						<td><?php echo $this->Form->input("PollVotingOption.{$k}.name",array("label"=>false)); ?></td>
						<td>
							
						</td>
						<td>
							
						</td>
					</tr>
					<?php endforeach ?>
				</table>
			
		<?php else: ?>
			<div class="alert alert-important">
				No Options Have Been Added
			</div>
		<?php endif ?>
	</div>
</div>
<div class="form-actions">
	<button class="btn btn-primary">Update Poll</button>
</div>
<?php echo $this->Form->end(); ?>
