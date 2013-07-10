<div class="canteenPromoCodes form">
<?php echo $this->Form->create('CanteenPromoCode',array("enctype"=>"multipart/form-data"));?>
	<fieldset>
		<legend><?php echo __('Edit Canteen Promo Code'); ?></legend>
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
		<?php if(!empty($this->request->data['CanteenPromoCode']['icon_file'])): ?>
		<div>
			<img border='0' src='http://img01.theberrics.com/canteen-promo-icons/<?php echo $this->request->data['CanteenPromoCode']['icon_file']; ?>' />
		</div>
		<?php endif; ?>
	<?php 
			echo $this->Form->input("icon_file",array("type"=>"file"));
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $this->Form->value('CanteenPromoCode.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('CanteenPromoCode.id'))); ?></li>
		<li><?php echo $this->Admin->link(__('List Canteen Promo Codes'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List Canteen Orders'), array('controller' => 'canteen_orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Canteen Order'), array('controller' => 'canteen_orders', 'action' => 'add')); ?> </li>
	</ul>
</div>