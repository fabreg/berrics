<div class="canteenPromoCodes form">
<?php echo $this->Form->create('CanteenPromoCode',array("enctype"=>"multipart/form-data"));?>
	<fieldset>
		<legend><?php __('Edit Canteen Promo Code'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('expire_date');
		echo $this->Form->input('start_date');
		echo $this->Form->input('user_id');
		echo $this->Form->input('name');
		echo $this->Form->input('rate');
		echo $this->Form->input('promo_type');
		echo $this->Form->input('promo_code');
	?>
		<?php if(!empty($this->data['CanteenPromoCode']['icon_file'])): ?>
		<div>
			<img border='0' src='http://img.theberrics.com/canteen-promo-icons/<?php echo $this->data['CanteenPromoCode']['icon_file']; ?>' />
		</div>
		<?php endif; ?>
	<?php 
			echo $this->Form->input("icon_file",array("type"=>"file"));
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('CanteenPromoCode.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('CanteenPromoCode.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Canteen Promo Codes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Canteen Orders', true), array('controller' => 'canteen_orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Canteen Order', true), array('controller' => 'canteen_orders', 'action' => 'add')); ?> </li>
	</ul>
</div>