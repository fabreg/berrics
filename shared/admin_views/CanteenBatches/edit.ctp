<div class="canteenBatches form">
<?php echo $this->Form->create('CanteenBatch');?>
	<fieldset>
 		<legend><?php echo __('Edit Canteen Batch'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('name');
		echo $this->Form->input('CanteenOrder');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $this->Form->value('CanteenBatch.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('CanteenBatch.id'))); ?></li>
		<li><?php echo $this->Admin->link(__('List Canteen Batches'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Canteen Orders'), array('controller' => 'canteen_orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Canteen Order'), array('controller' => 'canteen_orders', 'action' => 'add')); ?> </li>
	</ul>
</div>