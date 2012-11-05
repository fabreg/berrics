<?php 


$tag_array = Set::extract("/Tag/name",$this->request->data);

$tag_str = implode(",",$tag_array);

?>

<div class="page-header">
	<h1>Edit Dailyops Section</h1>
</div>
<?php echo $this->Form->create('DailyopSection',array('enctype'=>"multipart/form-data"));?>
<div>
	<?php

		echo $this->Form->input('id');
		echo $this->Form->input("active");
		echo $this->Form->input('name');
		echo $this->Form->input("nav_label",array("type"=>"textarea"));
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
</div>
<?php echo $this->Form->end(__('Submit'));?>
