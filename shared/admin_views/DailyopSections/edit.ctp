<?php 


$tag_array = Set::extract("/Tag/name",$this->request->data);

$tag_str = implode(",",$tag_array);

?>
<div class="dailyopSections form">
<?php echo $this->Form->create('DailyopSection',array('enctype'=>"multipart/form-data"));?>
	<fieldset>
 		<legend><?php echo __('Edit Dailyop Section'); ?></legend>
	<?php

		echo $this->Form->input('id');
		echo $this->Form->input("active");
		echo $this->Form->input('name');
		echo $this->Form->input("nav_label");
		echo $this->Form->input("uri");
		echo $this->Form->input("description");
		echo $this->Form->input("directive",array("options"=>DailyopSection::directives(),"empty"=>"*Standard"));
		echo $this->Form->input("section_view_override",array("options"=>Arr::sectionViewOverrides(),"label"=>"Section View Override (** Only Applies to the 'Standard' Directive **)"));
		echo $this->Form->input("featured");
		echo $this->Form->input("sort_weight");
		echo $this->Form->input("icon_light_file",array("type"=>"file"));
		echo $this->Form->input("icon_dark_file",array("type"=>"file"));
		echo $this->Form->input('Tag',array("type"=>"text","label"=>"Tags ( Multiple tags should be comma sperated )","value"=>$tag_str));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $this->Form->value('DailyopSection.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('DailyopSection.id'))); ?></li>
		<li><?php echo $this->Admin->link(__('List Dailyop Sections'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List Dailyops'), array('controller' => 'dailyops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Dailyop'), array('controller' => 'dailyops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Tags'), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>