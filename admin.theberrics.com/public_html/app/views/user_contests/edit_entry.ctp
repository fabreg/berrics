<div class='form'>
	<fieldset>
		<legend>Edit Contest Entry (ID: <?php echo $this->data['UserContestEntry']['id']; ?>)</legend>
		<?php 
		
			echo $this->Form->create("UserContestEntry",array("url"=>$this->here));
		?>
		<div>
			Contest: <?php echo $this->data['UserContest']['name']; ?>
		</div>
		<div>
			User: <a href='/users/edit/<?php echo $this->data['User']['id']; ?>' target='_blank'><?php echo $this->data['User']['first_name']; ?> <?php echo $this->data['User']['last_name']; ?></a> <a>(Facebook)</a>
		</div>
		<?php 
			echo $this->Form->input("winning_rank");
			echo $this->Form->input("id");
			echo $this->Form->end("Edit Entry"); 
		?>
	</fieldset>
</div>