<script>
$(document).ready(function() { 


	$('#ajax a').click(function() { 

		var url = $(this).attr("href");

		$.ajax({

			"url":url,
			"success":function(d) {

				$("#ajax").html(d);
				initBoostrap();

			}

		});

		
		return false;

	});

	$('.attach-button').click(function() { 

		var eid = $(this).attr("element_id");

		$("#"+eid).appendTo("#selected-files");

	});

	$('.remove-button').click(function() { 
		
		var eid = $(this).attr("element_id");

		var e = $("#"+eid);

		e.remove();

	});

	
});
</script>
<style>
.file {

	width:17.9%;
	margin-left:.5%;
	margin-right:.5%;
	float:left;
	margin-bottom:5px;
	border-radius:12px;
	border:1px solid #f0f0f0;
	background-color:#f6f6f8;
	height:260px;
}

.file .inner {

	padding:5px;

}

.file .image {

	min-height:125px;
	padding-top:8px;
	padding-bottom:8px;
	text-align:center;

}

.file .bottom {

	padding-bottom:10px;

}

.file .bottom .t {

	whitespace:no-wrap;

}

#selected-files .attach-button {

	display:none;

}

#ajax .remove-button {

	display:none;

}

.file p {
	
	min-height:40px;
	line-height:13px;
	font-size:12px;
}


/* Large desktop */
@media (min-width: 1200px) { 


}
 
/* Portrait tablet to landscape and desktop */
@media (min-width: 768px) and (max-width: 979px) { 

	.file {
	
		width:47.9%;
	
	}

}
 
/* Landscape phone to portrait tablet */
@media (max-width: 767px) {

	.file {
	
		width:47.9%;
	
	}
	

}
 
/* Landscape phones and down */
@media (max-width: 480px) { 
	
	.file {
	
		width:99%;
	
	}


}
</style>

<?php 

echo $this->Admin->adminPaging();

?>
<div class='sorting'>
	<?php echo $this->Paginator->sort("created"); ?>
</div>
<div class='tiles'>
	<?php 
	
		$types = MediaFile::mediaFileTypes();
	
		foreach($media as $file): 
	
		$m = $file['MediaFile'];
		
		$eid = "file".$m['id'];
		
	?>
	<div class='file' id='<?php echo $eid; ?>'>
		<div class='inner'>
			<div class='row-fluid'>
				<div class='span12'>
					<div class='image'>
						<?php echo $this->Media->mediaThumb(array(
												"MediaFile"=>$m,
												
												"h"=>"120"
											),array("class"=>"img-polaroid")); ?>
					</div>
					<div class='bottom'>
						<div>
							<button type='button' class='btn btn-success span12 attach-button' element_id='<?php echo $eid; ?>'>Attach</button>
							<button type='button' class='btn btn-danger span12 remove-button' element_id='<?php echo $eid; ?>'>Remove</button>
						</div>
						<div style='text-align:center;'>
							<p>
								<?php echo $m['name']; ?>&nbsp;
							</p>
							<div>
								<span class='label label-warning'><?php echo strtoupper($types[$m['media_type']]); ?></span>
							</div>
						</div>
					</div>
					<?php 
						echo $this->Form->text("id",array("name"=>"data[AttachMedia][media_file_id][]","value"=>$m['id'],"type"=>"hidden")); 
					?>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>