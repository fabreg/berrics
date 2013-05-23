<div class="polls form">
<?php echo $this->Form->create('Poll'); ?>

	<?php

		echo $this->Form->input('name');

	?>

<?php echo $this->Form->end(__('Submit')); ?>
</div>