<div class="tags form">
<?php echo $this->Form->create('Tag');?>
	<fieldset>
 		<legend><?php __('Add Tag'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('Banner');
		echo $this->Form->input('DailyopSection');
		echo $this->Form->input('Dailyop');
		echo $this->Form->input('MediaFile');
		echo $this->Form->input('TrikipediaTrick');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Tags', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dailyop Sections', true), array('controller' => 'dailyop_sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dailyop Section', true), array('controller' => 'dailyop_sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dailyops', true), array('controller' => 'dailyops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dailyop', true), array('controller' => 'dailyops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media Files', true), array('controller' => 'media_files', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media File', true), array('controller' => 'media_files', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Trikipedia Tricks', true), array('controller' => 'trikipedia_tricks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trikipedia Trick', true), array('controller' => 'trikipedia_tricks', 'action' => 'add')); ?> </li>
	</ul>
</div>