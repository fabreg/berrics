<div class="page-title">
	<h1>Add New Unified Store</h1>
</div>
<?php echo $this->Form->create('UnifiedStore');?>
	<?php
		echo $this->Form->input('shop_name');
	?>
<?php echo $this->Form->end(__('Submit'));?>
