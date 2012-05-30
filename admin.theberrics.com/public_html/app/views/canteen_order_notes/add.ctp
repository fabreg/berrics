<div class="canteenOrderNotes form">
<?php echo $this->Form->create('CanteenOrderNote');?>
	<fieldset>
		<legend><?php __('Add Canteen Order Note'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('message');
		echo $this->Form->input('user_id');
		echo $this->Form->input('hidden');
		echo $this->Form->input('feedback_required');
		echo $this->Form->input('parent_id');
		echo $this->Form->input('canteen_order_id');
		echo $this->Form->input('customer_reply');
		echo $this->Form->input('note_status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Canteen Order Notes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Canteen Order Notes', true), array('controller' => 'canteen_order_notes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Canteen Order Note', true), array('controller' => 'canteen_order_notes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Canteen Orders', true), array('controller' => 'canteen_orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Canteen Order', true), array('controller' => 'canteen_orders', 'action' => 'add')); ?> </li>
	</ul>
</div>