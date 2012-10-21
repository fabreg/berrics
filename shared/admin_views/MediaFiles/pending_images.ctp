<script>

$(document).ready(function() { 


	$('.image-form').ajaxForm({ 

		success:function(d) { 

			var tmp_id = d.MediaFile.tmp_id;

			$("#"+tmp_id).remove();

		},
		"dataType":"json"

	});

	$('.reject-image').click(function() { 

		
		
		$.post("/media_files/reject_image",{

			"tmp_image":$(this).attr("tmp_image")
			
		},function(d) { 
			console.log(d);
			
			
		});

		$("#"+$(this).attr("tmp_id")).remove();
		
	});

	
});

</script>
<div class='index'>
	<div class='page-header'>
		<h1>Pending Image Uploads</h1>
	</div>
	<?php foreach($files as $v): ?>
	<?php  
		$id = uniqid("image-");
		$url = array(
			"action"=>"commit_pending_image"		
		);
	?>
	<div class='row-fluid' id='<?php echo $id; ?>'>
		<div class='span12 well'>
			<div class='row-fluid'>
				<div class='span4'>
					<img border='0' src='/media_files/tmp_image/<?php echo $v; ?>' />
				</div>
				<div class='span8'>
					<?php 
						echo $this->Form->create("MediaFile",array("url"=>$url,"class"=>"form image-form"));
						echo $this->Form->input("name");
						echo $this->Form->input("tags");
						echo $this->Form->input("tmp_image",array("type"=>"hidden","value"=>$v));
						echo $this->Form->input("tmp_id",array("type"=>"hidden","value"=>$id));
						echo $this->Form->submit("Commit Image");
						echo $this->Form->end();
					?>
					<button type='button' class='btn btn-danger reject-image' tmp_image='<?php echo $v; ?>' tmp_id='<?php echo $id; ?>'>Reject Image</button>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>