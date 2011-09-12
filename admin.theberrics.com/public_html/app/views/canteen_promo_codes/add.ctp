<div class="canteenPromoCodes form">
<?php echo $this->Form->create('CanteenPromoCode');?>
	<fieldset>
 		<legend><?php __('Add Canteen Promo Code'); ?></legend>
	<?php
		echo $this->Form->input('expire_date');
		echo $this->Form->input('start_date');
		echo $this->Form->input('user_id');
		echo $this->Form->input('name');
		echo $this->Form->input('rate');
		echo $this->Form->input('promo_type');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Canteen Promo Codes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>