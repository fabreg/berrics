<?php

if(isset($cat)) {

	$parent = "( Parent Category: ".$cat['CanteenCategory']['name'].")";
} else {
	
	$hidden = '';
	$parent = '';
	
}

?>
<div class='form'>
	<fieldset>
		<legend>Add New Category <?php echo $parent; ?></legend>
		<?php 
		
			echo $this->Form->create("CanteenCategory");
			if(isset($cat)) {
				
				echo $this->Form->input("parent_id",array("value"=>$cat['CanteenCategory']['id'],"type"=>"hidden"));
				
			}
			echo $this->Form->input("name");
			echo $this->Form->input("uri");
			echo $this->Form->input("active");
			echo $this->Form->input("browsable");
			echo $this->Form->end("Add New Category");
		
		?>
	</fieldset>
</div>