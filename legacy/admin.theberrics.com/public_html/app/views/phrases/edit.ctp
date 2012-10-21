<div class="phrases form">
<?php echo $this->Form->create('Phrase');?>
	<fieldset>
 		<legend><?php __('Edit Phrase'); ?></legend>
 		<div>
 			Section: <?php echo $en_lang['Phrase']['section']; ?>
 		</div>
 		<div>
 			Token: <?php echo $en_lang['Phrase']['token']; ?>
 		</div>
 		<div>
 			Raw Value: <?php echo $en_lang['Phrase']['raw_value']; ?>
 		</div>
	<?php
		echo $this->Form->input('id');
		//echo $this->Form->input('section');
		//echo $this->Form->input('token');
		
		echo $this->Form->input('value',array("value"=>$translate_lang['Phrase']['value'],"label"=>" Value (".$this->Session->read("ControlPanel.translate_locale")."):"));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Phrase.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Phrase.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Phrases', true), array('action' => 'index'));?></li>
	</ul>
</div>