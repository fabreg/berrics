<div class="dailyops form">
<?php echo $this->Form->create('Dailyop');?>
	<fieldset>
 		<legend>New Dailyop's Post</legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input("sub_title");
		echo $this->Form->input('dailyop_section_id');
	?>
	</fieldset>
<?php echo $this->Form->end("Next >");?>
</div>
