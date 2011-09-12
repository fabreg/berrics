<div class="dailyopSections form">
<?php echo $this->Form->create('DailyopSection');?>
	<fieldset>
 		<legend><?php __('Add Dailyop Section'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input("description");
		echo $this->Form->input('Tag',array("type"=>"text","label"=>"Tags ( Multiple tags should be comma sperated )"));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Dailyop Sections', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Dailyops', true), array('controller' => 'dailyops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dailyop', true), array('controller' => 'dailyops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags', true), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag', true), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>