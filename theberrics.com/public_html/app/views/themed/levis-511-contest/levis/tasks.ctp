<?php 
	echo $this->Html->css(array("uploadify.css"),"stylesheet");

	
?>
<script type='text/javascript'>
$(document).ready(function() { 

	
	$("#image_file").uploadify({
			
				'swf'      : '/swf/uploadify.swf',
	        	'uploader' : '/levis-511/handle_upload?xid=<?php echo $this->Session->id(); ?>',
	        	"fileTypeExts":"*.gif; *.jpg; *.jpeg; *.png",
	        	"debug":false,
	        	"buttonImage":"/theme/levis-511-contest/img/upload-button.png",
	        	"height":"37",
	        	"width":"161",
	        	"onUploadSuccess":function(f,d,r) {

	        		var data = eval("("+d+")");

					$("#MediahuntMediaItemFileName").val(data.file_name);
					$("#MediahuntMediaItemInstagramId").val('');
					$("#MediahuntMediaItemInstagramData").val('');

					showTmpThumb(data.file_name);
					removeFormOverlay();
		        		
	        	},
	        	'onUploadStart':function() {
					showFormOverlay("test");
	        	},
	        	"queueID":"fileQueue"
	            // Put your options here
		            
	});



	$("#reset-form").click(function() { 

		document.location.reload(true);

	});

	$('.instagram-thumb').click(function() { 

		var id = $(this).attr("instagram_id");

		attachInstagram(id);

	});

	$("#levis-form").submit(function() { 

		var img = $("#levis-form #MediahuntMediaItemFileName").val();

		if(img.length<=0) {

			alert("Please select an image to submit your entry");
			
			return false

		}

		return true;

	});

<?php
if(!empty($mediaItem['MediahuntMediaItem']['id'])) {
	
	echo "$.LevisContest('handleClose');";
	
}
?>
	
});

function showTmpThumb(file) {

	var url = "http://img.theberrics.com/i.php?src=/tmp/"+file+"&w=337&h=234&zc=0";

	var img = $("<img />").attr({
			"src":url,
			"border":"0"
		});

	$(".upload-preview .inner").html(img);
	
}

function showFormOverlay(msg) {

	var div = $("<div class='levis-upload-overlay'/>").append("<div class='inner'/>");

	//$("#levis-upload-overlay .form-msg").html(msg);
	
	$("#levis-task").append(div);
	
}

function removeFormOverlay() {

	$('.levis-upload-overlay').remove();
	
}

function attachInstagram(id) {

	showFormOverlay();
	
	var o = {


				"url":"/<?php echo $this->params['section']; ?>/attach_instagram/"+id,
				"dataType":"json",
				"success":function(d) { 

					if(d.status==true) {

						$("#MediahuntMediaItemInstagramId").val(id);
						$("#MediahuntMediaItemInstagramData").val(JSON.stringify(d.image));
						$("#MediahuntMediaItemFileName").val(d.file_name);
						showTmpThumb(d.file_name);
						
						
					} else {

						alert("Whoops, we were unable to attach your instagram photo, please try again");
						
					}
					removeFormOverlay();

				}

			}

	$.ajax(o);
	
}
</script>
<style>

#LevisOverlay .wrapper {
	
	width:728px;
	margin:auto;

}

#levis-task {

	background-color:#000;
	padding:5px;
	position:relative;
	border:4px solid #333;
}

#fileQueue {
	
	displauy:none;
	height:0px;
	width:0px;
	overflow:hidden;
}

.levis-upload-overlay {

	position:absolute;
	height:100%;
	width:100%;
	background-image:url(/img/layout/blk-px.png);
	top:0px;
	left:0px;
	z-index:9001
}

.levis-upload-overlay .inner {

	background-image:url(/img/layout/ajax-loader.gif);
	background-position:center center;
	height:100%;
	width:100%;
	position:absolute;
		top:0px;
	left:0px;
	z-index:9002;
	background-repeat:no-repeat;
}

#SwfUpload {

	float:right;
	

}
.instagram-connect {

	float:right;
	margin-left:10px;

}

.uploadify-button {
        background-color: transparent;
        border: none;
        padding: 0;
        height:100px;
        width:100px;
    }
.img-thumb {

	float:left;
	width:120px;
	height:100px;

}
.form-fields {

	float:right;
	width:300px;

}

.upload-form .left {

	float:left;
	margin-top:8px;
	margin-left:8px;
}

.upload-form .right {

	float:right;
	width:330px;
	margin-top:8px;
	margin-right:8px;
}

.upload-form .upload-preview {

	background-image:url(/theme/levis-511-contest/img/upload-preview-bg.png);
	height:242px;
	width:345px;
	text-align:center;
}

.upload-form .upload-preview .inner {
	
	padding:4px;

}

.upload-form .task-name {
	font-family:'Arial';
	color:#fff;
	font-weight:bold;
	margin-top:10px;
	
}
.upload-form .task-details {
	font-family:'Arial';
	color:#fff;
	font-style:italic;
	font-size:14px;
	border-bottom:1px dashed #7c001b;
	padding-bottom:8px;

}
.form-buttons {

	margin-top:8px;

}

.form-buttons .left {

	width:345px;
	float:left;

}

.form-buttons .right {

	width:330px;
	float:right;
	text-align:center;

}

.form-buttons .right .submit input {

	width:283px;
	height:43px;
	border:none;
	background-color:transparent;
	background-image:url(/theme/levis-511-contest/img/submit-button.png);
	text-index:-10000px;
}

.instagram-container {

	border-top:4px solid #333;
font-family:'Arial';
	color:#cc0033;
}

.instagram-thumb {

	border:2px solid #cc0033;
	float:left;
	margin:17px;
	cursor:pointer;
	
}

.instagram-thumb img {

	display:block;
	padding:0px;
	margin:0px;

}
input[type=submit] {

	cursor:pointer;

}

.task-sort-order {
	padding-top:4px;
	color:#cc0033;
	font-weight:bold;
border-top:1px dashed #7c001b;
font-family:'Arial';
}

</style>
<div id='levis-task'>

<div class='upload-form'>
	<div class='left'>
		<div class='upload-preview'><div class='inner'></div></div>
	</div>
	<div class='right'>
		<div style='text-align:center;'><img src='/theme/levis-511-contest/img/upload-logo.png' border='0' /></div>
		<div class='task-sort-order'>
			Photo Challenge #<?php echo $task['MediahuntTask']['sort_order']; ?>
		</div>
		<div class='task-name'>
			<?php echo $task['MediahuntTask']['name']; ?>
		</div>
		<div class='task-details'>
			<?php echo $task['MediahuntTask']['details']; ?>
		</div>
	</div>
	<div style='clear:both;'></div>
</div>
<div class='form-buttons'>
	<div class='left'>
		
		<?php if(!$instagram_images): ?>
		<?php 
			$instagram_link = $this->Html->url(array(
						"plugin"=>"identity",
						"controller"=>"login",
						"action"=>"send_to_instagram",
						base64_encode($this->here)
					),array("rel"=>"no-ajax"));
		?>
		<div class='instagram-connect'>
		<a href='<?php echo $instagram_link; ?>' rel='no-ajax'><img border='0' src='/theme/levis-511-contest/img/instagram-button.png' /></a>
		</div>
		<?php endif; ?>
		<?php echo $this->Form->input("image_file",array("type"=>"file","div"=>array("id"=>"SwfUpload"),"label"=>false)); ?>
		
	</div>
	<div class='right'>
		<?php 
		
			echo $this->Form->create("MediahuntMediaItem",array("url"=>array("action"=>"handle_submit","controller"=>$this->params['section']),"rel"=>"no-ajax","id"=>"levis-form")); 
			echo $this->Form->input("file_name",array("type"=>"hidden"));
			echo $this->Form->input("mediahunt_task_id",array("value"=>$task['MediahuntTask']['id'],"type"=>"hidden"));
			echo $this->Form->input("instagram_id",array("type"=>"hidden"));
			echo $this->Form->input("instagram_data",array("type"=>"hidden"));
			echo $this->Form->submit(" ");
			echo $this->Form->end();
		?>
	</div>
	<div style='clear:both;'></div>
	<div id='fileQueue'></div>
</div>
	<div class='instagram-container'>

		<?php if(isset($instagram_images)): ?>
		<div class='instagram-heading'>Choose a photo from Instagram: <strong>@<?php echo $this->Session->read("Auth.User.instagram_handle"); ?></strong></div>
		<div class='instagram-thumbs'>
			<?php foreach($instagram_images->data as $img): ?>
			<div style='float:left' class='instagram-thumb' instagram_id='<?php echo $img->id; ?>'>
				<img src='<?php echo $img->images->thumbnail->url; ?>' border='0' height='100' width='100' />
			</div>
			<?php endforeach; ?>
			<div style='clear:both;'></div>
			<?php //print_r($instagram_images); ?>
		</div>
		<?php else: ?>
		
		<?php endif; ?>
	</div>
</div>
<?php 
//print_r($task);
//print_r($mediaItem);
//print_r($instagram_images);
?>