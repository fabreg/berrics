<div class="unifiedStores form">
<?php echo $this->Form->create('UnifiedStore',array("enctype"=>"multipart/form-data"));?>
	<fieldset>
 		<legend><?php echo __('Edit Unified Store'); ?></legend>
	<?php
		echo $this->Form->input('id');
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
		//echo $this->Form->input('shop_logo');
		//echo $this->Form->input('shop_path');
		
		echo $this->Form->input("image_logo",array("type"=>"file"));
		echo $this->Form->input('latitude');
		echo $this->Form->input('longitude');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>