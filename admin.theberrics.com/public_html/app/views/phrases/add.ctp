<div class="phrases form">
<?php echo $this->Form->create('Phrase');?>
	<fieldset>
 		<legend><?php __('Add Phrase'); ?></legend>
	<?php
		echo $this->Form->input('section');
		echo $this->Form->input('token');
		echo $this->Form->input('value');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Phrases', true), array('action' => 'index'));?></li>
	</ul>
</div>