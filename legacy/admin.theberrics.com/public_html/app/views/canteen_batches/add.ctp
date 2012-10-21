<div class="canteenBatches form">
<?php echo $this->Form->create('CanteenBatch');?>
	<fieldset>
 		<legend><?php __('Add Canteen Batch'); ?></legend>
	<?php
		echo $this->Form->input('user_id',array("type"=>"hidden","value"=>$this->Session->read("Auth.User.id")));
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Canteen Batches', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Canteen Orders', true), array('controller' => 'canteen_orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Canteen Order', true), array('controller' => 'canteen_orders', 'action' => 'add')); ?> </li>
	</ul>
</div>