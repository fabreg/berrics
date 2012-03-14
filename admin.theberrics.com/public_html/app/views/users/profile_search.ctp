<div class='form index'>
	<fieldset>
		<legend>Search Users</legend>
		<?php echo $this->Form->create("User",array("url"=>$this->here)); ?>
		<div>
			<div style='width:40%; float:left;'>
				<?php echo $this->Form->input("first_name"); ?>
			</div>
			<div style='width:40%; float:left;'>
				<?php echo $this->Form->input("last_name"); ?>
			</div>
			<div style='clear:both;'></div>
		</div>
		<?php echo $this->Form->end("Search"); ?>
	</fieldset>
</div>