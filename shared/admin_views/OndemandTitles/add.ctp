<div class="ondemandTitles form">
<?php echo $this->Form->create('OndemandTitle');?>
	<fieldset>
 		<legend><?php echo __('Add Ondemand Title'); ?></legend>
	<?php
		echo $this->Form->input('title');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>