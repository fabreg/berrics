<script>

$(document).ready(function() { 


	//bind all the forms to use ajaxSubmit

	$(".image-file form").ajaxForm({

		"beforeSubmit":function() { 
			
		},
		"success":function(d,t,x,e) {

			$(e).html(d).parent().find(".process-cancel").hide();

		}

	});

	$(".process-cancel").click(function() { 

		$(this).parent().parent().html("Processing Canceled For This Image....");

	});


	$("#super_tag").change(function() { 
		var v = $(this).val();
		$(".super-tag").each(function() { 

				$(this).val(v);

		});

	});

	$('#super-submit').click(function() { 

		$('.image-file form').each(function() { 

			$(this).submit();

		});

	});
	
});

</script>
<style>

.image-file {

}

.image-file .preview {

	float:left;
	width:220px;
	
}

.image-file .form-data {

	float:left;
	width:500px;

}

#done-div  {

	text-align:center;
	font-size:180%;
	font-weight:bold;

}

</style>
<div class='form'>
	<?php 
	
		echo $this->Form->input("SuperTag",array("id"=>"super_tag"));
	
	?>
	<input type='button' id='super-submit' value='super submit!' />
	<div>
		<p>Enter the data for each image or press skip to cancel processing the image. NOTE*: You can always go back and modify the info attached to the image</p>
	</div>
	<?php 
	$i = 1;
	foreach($fileData as $file):
	
	?>
	<div class='image-file'>
		
			<fieldset>
			<legend>Image: <?php echo $i; ?></legend>
				<?php 
				
					echo $this->Form->submit("Skip",array("class"=>"process-cancel"));
				
				?>
				<?php echo $this->Form->create("MediaFile",array("url"=>array("controller"=>"media_files","action"=>"ajax_process_image_queue_post"))); ?>
				<div class='preview'>
					<?php $thb = $this->Thumb->tmpThumb(array(
									
									"src"=>$file['fullPath'],
									"w"=>200,
									"h"=>200
										
								));

						echo $this->Html->image($thb);			
					?>
				</div>
				<div class='form-data'>
					<?php 
						
						echo $this->Form->input("name");
						echo $this->Form->input("caption");
						echo $this->Form->input("tags",array("label"=>"Tags (Multiple tags should be comma seperated)",'class'=>'super-tag'));
						echo $this->Form->input("url",array("label"=>"Url ( USE HTTP:// )"));
						echo $this->Form->input("user_id",array("type"=>"hidden","value"=>$this->Session->read("Auth.User.id")));
						echo $this->Form->input("website_id");
						echo $this->Form->input("file",array("type"=>"hidden","value"=>$file['fileName']));
						echo $this->Form->input("media_type",array("type"=>"hidden","value"=>"image"));
						echo $this->Form->input("fullPath",array("type"=>"hidden","value"=>$file['fullPath']));
						
					?>
				</div>
				<div style='clear:both'></div>
					<?php echo $this->Form->end("Process Image")?>
			</fieldset>
	
	</div>
	<?php 
	$i++;
	endforeach;
	
	?>
	<div id='done-div'>
		<?php echo $this->Html->link("View Media Files",array("controller"=>"media_files","action"=>"index")); ?>
	</div>
</div>