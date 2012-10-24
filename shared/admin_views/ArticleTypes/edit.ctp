<div class="articleTypes form">
<?php echo $this->Form->create('ArticleType');?>
	<fieldset>
 		<legend><?php echo __('Edit Article Type'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('sort_weight',array("options"=>ArticleType::sortWeights()));
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $this->Form->value('ArticleType.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('ArticleType.id'))); ?></li>
		<li><?php echo $this->Admin->link(__('List Article Types'), array('action' => 'index'));?></li>
	</ul>
</div>