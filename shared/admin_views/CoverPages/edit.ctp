<script>
$(document).ready(function() { 


	$( "#CoverPagePublishDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	$(".attach-link a").click(function() { 

		var href = $(this).attr("href");

		$(".form form").ajaxSubmit(function() { 


			document.location.href = href;

		});
		
		return false;

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
		<legend>Edit Cover Page</legend>
		<?php 
		
			echo $this->Form->create("CoverPage",array("url"=>$this->request->here));
			
			echo "<div style='font-size:120%; font-weight:bold;'>Category :";
			if($this->request->data['AberricaCategory']['id']>0) {
				
				echo $this->request->data['AberricaCategory']['name'];
				
			} else {
			
				echo "Home Page";
				
			}
			echo "</div>";
			echo $this->Form->input("active");
			echo $this->Form->input("title");
			echo $this->Form->input("publish_date",array("type"=>"text"));
		?>
		<?php 
		
			if(isset($this->request->data['MediaFile']['id'])) {
				
				echo $this->Media->mediaThumb(array(
				
					"MediaFile"=>$this->request->data['MediaFile'],
					"w"=>300,
					"h"=>200
				
				));
				
			}
		
		?>
			<div class='attach-link' style='padding:10px;'>
				<?php echo $this->Admin->attachMediaLink("CoverPage","id",$this->request->data['CoverPage']['id'],$this->request->here); ?>
			</div>
		<?php
		
			echo $this->Form->input("text_content");
			echo $this->Form->input("external_url");
		
		
		?>
		<?php 
			echo $this->Form->end("Update Cover Page");
		?>
	</fieldset>
</div>
<?php 



pr($this->request->data);

?>