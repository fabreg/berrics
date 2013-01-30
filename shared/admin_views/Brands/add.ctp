<div class="brands form">
<?php echo $this->Form->create('Brand');?>
	<fieldset>
 		<legend><?php __('Add Brand'); ?></legend>
	<?php
		echo $this->Form->input('active');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('featured');
		echo $this->Form->input('image_logo');
		echo $this->Form->input('website_url');
		echo $this->Form->input('established_date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Brands', true), array('action' => 'index'));?></li>
	</ul>
</div>