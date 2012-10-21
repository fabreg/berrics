<?php 

$this->Html->script(array("swfupload"),array("inline"=>false));

?>
<script>

var upload = {};
var xid = "<?php echo $this->Session->id(); ?>";
$(document).ready(function() { 


	var opt = {
			
			flash_url:"/swf/swfupload.swf",
			button_placeholder_id:"file-upload-button",
			button_image_url:"/img/layout/for-the-record/submit-video-button.png",
			button_height:50,
			button_width:295,
			button_window_mode : SWFUpload.WINDOW_MODE.TRANSPARENT,
			upload_url:"/for-the-record/handle_upload?xid="+xid,
			file_types:"*.mp4;*.mov;*.mpg;*.mpeg",
			file_types_description: "Update us with a video",
			file_queue_limit:1,
			file_queued_handler:function(f) {

				this.setPostParams({
					"berrics_record_id":'<?php echo $this->params['pass'][0]; ?>'
				});

				showModal();
				
				this.startUpload();
			
			},
			file_queue_error_handler:function(f,e,m) {
				
				
			},
			upload_start_handler:function(f) {
				
				
			},
			upload_progress_handler:function(f,bl,bt) {
				
				//get the percentage
				var percent = roundNumber((bl/bt)*100,2);
				
				
				if(percent<100) {
					
					var htm = "<div style='line-height:25px;'>Uploading Video To The Berrics...</div>";
					
					htm += "<div style='line-height:25px; text-align:center;'>"+percent+"%</div>";
					
					htm += "<div style='height:20px; border:2px solid #999; width:80%; margin:auto; position:relative;'><div style='postion:absolute; background-color:#333; overflow:visible; height:20px; left:0px; top:0px; width:"+percent+"%;'></div></div>";
	
				} else {
					
					var htm = "<div style='line-height:140px;'>Processing Video... Uno momento..</div>";
					
				}
				
				updateMsg(htm);
				
			},
			upload_complete_handler:function() {
			
				var html = "<div style='padding-top:30px;'>Your video has been submitted successfully <br /> <div><a href='/for-the-record'>Close Window</a></div></div>";

				updateMsg(html);
				
			},
			upload_success_handler:function(f,d,r) {
				
				
				
			},
			debug:true
			
		};

	upload = new SWFUpload(opt);

	
});

function showModal() {

	$("body").prepend("<div id='upload-overlay'><div class='upload-content'></div></div>");

	resizeModal();

	$(window).scrollTo(0,0);
}

function resizeModal() {

	$("#upload-overlay").css({

		"height":"100%",
		"width":"100%",
		"background-image":"url(/img/layout/blk-px.png)",
		"position":"absolute",
		"z-index":"10010"

	}).find('.upload-content').css({

		"margin":"auto",
		"width":"500px",
		"height":"175px",
		"background-color":"black",
		"border":"2px solid #9f8450",
		"text-align":"center"

	});
	
}

function updateMsg(s) {

	$("#upload-overlay .upload-content").html(s);
	
}

function closeModal() {


	
}
function roundNumber(num, dec) {
	
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
	
}
</script>
<div id='for-the-record-section'>
	<div class='record-plaq'>
		<div class='plaq-top'>
			
		</div>
		<div class='plaq-heading'>
			<div class='inner'>
				<?php echo strtoupper($record['BerricsRecord']['record_name']); ?>
				<div class='challenge-div'>
					<div style='font-size:18px;' class='current-holder'>
						<div>
							CURRENT RECORD HOLDER: <br /><span style='font-weight:bold;'><?php echo strtoupper($record['BerricsRecordsItem'][0]['User']['first_name']." ".$record['BerricsRecordsItem'][0]['User']['last_name']); ?></span>
						</div>
						<div>
							RESULT: <span style='font-weight:bold;'><?php echo $record['BerricsRecordsItem'][0]['result_label'];  ?></span>
						</div>
						<div>
							<span style='font-weight:bold;'><?php echo strtoupper(date('M jS, Y',strtotime($record['BerricsRecordsItem'][0]['Dailyop']['publish_date'])));  ?></span>
						</div>
					</div>
					<div id='challenge-form'>
						<table cellspacing='0'>
							<tr>
								<th>Video Upload</th>
							</tr>
							<tr>
								<td>
									<div>- Video Must Be In MPEG, MOV or MP4 Format</div>
									<div>- Video Can Be No Larger Than 80 MegaBytes</div>
									<div>- Berrics Rules Apply</div>
								</td>
							</tr>
							<tr>
								<td><span id='file-upload-button'></span>
								</td>
							</tr>
						</table>
					</div>
					<div style='clear:both;'></div>
				</div>
			</div>		
		</div>
		<div class='plaq-heading-bottom'></div>
		<div class='plaq-body'>
				<div class='inner'>
					
				</div>
				<div style='clear:both;'></div>
		</div>
		<div class='plaq-bottom'>
		
		</div>

	</div>
</div>