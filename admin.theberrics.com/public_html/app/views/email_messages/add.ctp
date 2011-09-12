<div class="emailMessages form">
<?php echo $this->Form->create('EmailMessage');?>
	<fieldset>
 		<legend><?php __('Add Email Message'); ?></legend>
	<?php
		echo $this->Form->input('sent_date');
		echo $this->Form->input('to');
		echo $this->Form->input('cc');
		echo $this->Form->input('bcc');
		echo $this->Form->input('reply_to');
		echo $this->Form->input('from');
		echo $this->Form->input('subject');
		echo $this->Form->input('template');
		echo $this->Form->input('layout');
		echo $this->Form->input('line_length');
		echo $this->Form->input('send_as');
		echo $this->Form->input('attachments');
		echo $this->Form->input('delivery');
		echo $this->Form->input('smtp_options');
		echo $this->Form->input('serialized_data');
		echo $this->Form->input('canteen_order_id');
		echo $this->Form->input('processed');
		echo $this->Form->input('debug_data');
		echo $this->Form->input('app_name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Email Messages', true), array('action' => 'index'));?></li>
	</ul>
</div>