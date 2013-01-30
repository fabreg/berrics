<script>
$(document).ready(function() { 


	$( "#CoverPagePublishDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	
});
</script>
<style>
#CoverPagePublishDate {

	width:250px;

}
</style>
<div class='form' style='width:800px; margin:auto;'>
<fieldset>
	<legend>Create Cover Page</legend>
	<?php 
	
	
		echo $this->Form->create("CoverPage",array("url"=>$this->request->here));
		echo "<div style='font-size:120%; font-weight:bold;'>";
			
			echo "Category: ";
			
			if(isset($cat['AberricaCategory']['name'])) {
				
				echo $cat['AberricaCategory']['name'];
				echo $this->Form->input("aberrica_category_id",array("type"=>"hidden","value"=>$cat['AberricaCategory']['id']));
				
			} else {
				
				echo "HomePage";
				
			}

		echo "</div>";
		echo $this->Form->input("title");
		
		echo $this->Form->input("publish_date",array("type"=>"text"));
		
		echo $this->Form->end("Add Cover Page");
	

	?>
</fieldset>
</div>