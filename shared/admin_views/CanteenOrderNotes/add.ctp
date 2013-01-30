<div class="canteenOrderNotes form">
<?php echo $this->Form->create('CanteenOrderNote');?>
	<fieldset>
		<legend><?php echo __('Add Canteen Order Note'); ?></legend>
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
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('List Canteen Order Notes'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Canteen Order Notes'), array('controller' => 'canteen_order_notes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Parent Canteen Order Note'), array('controller' => 'canteen_order_notes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Canteen Orders'), array('controller' => 'canteen_orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Canteen Order'), array('controller' => 'canteen_orders', 'action' => 'add')); ?> </li>
	</ul>
</div>