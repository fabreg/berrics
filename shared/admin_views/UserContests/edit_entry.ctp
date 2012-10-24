<div class='form'>
	<fieldset>
		<legend>Edit Contest Entry (ID: <?php echo $this->request->data['UserContestEntry']['id']; ?>)</legend>
		<?php 
		
			echo $this->Form->create("UserContestEntry",array("url"=>$this->request->here));
		?>
		<div>
			Contest: <?php echo $this->request->data['UserContest']['name']; ?>
		</div>
		<div>
			User: <a href='/users/edit/<?php echo $this->request->data['User']['id']; ?>' target='_blank'><?php echo $this->request->data['User']['first_name']; ?> <?php echo $this->request->data['User']['last_name']; ?></a> <a>(Facebook)</a>
		</div>
		<?php 
			echo $this->Form->input("winning_rank");
			echo $this->Form->input("id");
			echo $this->Form->end("Edit Entry"); 
		?>
	</fieldset>
</div>