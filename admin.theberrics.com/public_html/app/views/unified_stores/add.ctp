<div class="unifiedStores form">
<?php echo $this->Form->create('UnifiedStore');?>
	<fieldset>
 		<legend><?php __('Add Unified Store'); ?></legend>
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
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Unified Stores', true), array('action' => 'index'));?></li>
	</ul>
</div>