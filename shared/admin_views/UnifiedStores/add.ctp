<div class="unifiedStores form">
<?php echo $this->Form->create('UnifiedStore');?>
	<fieldset>
 		<legend><?php echo __('Add Unified Store'); ?></legend>
	<?php
		echo $this->Form->input('shop_name');
		echo $this->Form->input('address1');
		echo $this->Form->input('address2');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('full_state');
		echo $this->Form->input('zip');
		echo $this->Form->input('country');
		echo $this->Form->input('phone');
		echo $this->Form->input('shop_bio');
		echo $this->Form->input('shop_logo');
		echo $this->Form->input('shop_path');
		echo $this->Form->input('latitude');
		echo $this->Form->input('longitude');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('List Unified Stores'), array('action' => 'index'));?></li>
	</ul>
</div>