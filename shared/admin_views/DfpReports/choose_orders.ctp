<script>
$(document).ready(function() { 


	$( "#DfpReportDateStart,#DfpReportDateEnd").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	



	
});

</script>
<div class='form'>
	<?php 
	echo $this->Form->create("DfpReport",array("url"=>$this->request->here));
	?>
	<fieldset>
		<legend>Choose Orders:</legend>
	<?php 
	
		
		foreach($this->request->data['Orders'] as $o) {
			
			echo $this->Form->input("order".$o['id'],array(
			
				"type"=>"checkbox",
				"label"=>$o['name'],
				"value"=>json_encode($o),
				"name"=>"data[order][".$o['id']."]",
				"hiddenField"=>false
			
			));
			
		}
		
		
		
	?>
	</fieldset>
	<fieldset>
		<legend>Report Details</legend>
		<?php 
		
		
			echo $this->Form->input("name");
			echo $this->Form->input("notes");
			echo $this->Form->input("date_start",array("type"=>"text"));
			echo $this->Form->input("date_end",array("type"=>"text"));
		
		?>
	</fieldset>
	
	<?php 
	echo $this->Form->end("Generate");
	?>
</div>