<div class="dailyopSections form">
<?php echo $this->Form->create('DailyopSection');?>
	<fieldset>
 		<legend><?php echo __('Add Dailyop Section'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input("description");
		echo $this->Form->input('Tag',array("type"=>"text","label"=>"Tags ( Multiple tags should be comma sperated )"));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('List Dailyop Sections'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List Dailyops'), array('controller' => 'dailyops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Dailyop'), array('controller' => 'dailyops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Tags'), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>