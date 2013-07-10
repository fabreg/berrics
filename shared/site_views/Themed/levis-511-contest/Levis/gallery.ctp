<script>
$(document).ready(function() { 


	$('.items .img-thumb').click(function() { 

		var id = $(this).attr("item-id");
		
		popImage(id);
		
	});

	popImage(<?php echo $id; ?>);
	
});

function popImage(id) {

	showOverlay();
	
	$.ajax({

		'url':'/levis-nike-picture-perfect/image/'+id,
		'success':function(d) {

			$('#LevisGallery .image-view').html(d);
			removeFormOverlay();

		}

	});


	
	
}

function showOverlay(msg) {

	var div = $("<div class='levis-upload-overlay'/>").append("<div class='inner'/>");

	//$("#levis-upload-overlay .form-msg").html(msg);
	
	$("#LevisGallery").append(div);
	
}

function removeFormOverlay() {

	$('.levis-upload-overlay').remove();
	
}
</script>
<style>
#LevisOverlay .wrapper {

	width:90%;
	margin:auto;
	max-width:900px;

}
#LevisGallery {
	
	background-color:#000;
	padding:5px;
	position:relative;
	border:4px solid #333;
	position:relative;
}



#LevisGallery .gallery-item {
	
	float:left;
	width:135px;
	height:135px;
	margin:3px;
	padding:5px;
	border:3px solid #cc0033;
}


.items {

	border-top:4px solid #333;

}

.img-thumb {

	border:3px solid #cc0033;
	float:left;
	margin:7px;
	cursor:pointer;
	padding:3px;
}

.img-thumb img {

	display:block;
	padding:0px;
	margin:0px;
	
}

.task-info {

	border:2px dashed #cc0033;
	border-left:none;
	border-right:none;
	font-family:'Arial';
	padding-top:5px;
	padding-bottom:5px;
	
}

.task-div {

	float:right;
	width:380px;
}

.image {

	float:left;
	width:500px;
	text-align:center;
	
}

.image img {

border:3px solid #cc0033;
	padding:3px;

}

.image .inner {

	border:3px solid #cc0033;
	padding:2px;

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

.paging {

	padding:5px;
	

}

.task-info .name {


}
.task-info .user span {

	font-weight:bold;

}

.task-info .label {

	font-size:18px;
	font-weight:bold;
	color:#cc0033;
}
.paging {

	text-align:center;
	font-family:'Arial';
	margin-top:5px;
}

.paging .disabled {

	display:none;

}

.paging span {

	
	margin:2px;
	

}

.paging .current {

	padding:5px;
	background-color:#cc0033;
	color:#fff;
	border:2px solid #333;

}

.paging span a {
	
	text-decoration:none;
	border:2px solid #333;
	padding:5px;
}

</style>
<div id='LevisGallery'>
	<div class='image-view'>
		
	</div>
	<div class='items'>
		<div style='text-align:center; font-style:italic; font-size:10px;'>
			** Only Approved Images Are Shown ** <br /> ** If your image is not being displayed its either pending appoval or has been disqualified **
		</div>
		<div class='paging'>
		<?php echo $this->Paginator->prev('< PREVIOUS', array(), null, array('class'=>'disabled'));?>
	  	<?php echo $this->Paginator->numbers(array(
	  				"separator"=>""
	  			));?>
 
		<?php echo $this->Paginator->next('NEXT >', array(), null, array('class' => 'disabled'));?>
		</div>
		<?php 
			
			foreach($images as $img): 
				$m = $img['MediahuntMediaItem'];
		?>
			<div class='img-thumb' json-data="" item-id='<?php echo $m['id']; ?>'>
				<img src='http://img01.theberrics.com/i.php?w=100&h=100&zc=1&src=/mediahunt-media/<?php echo $m['file_name']; ?>'/>
			</div>
		<?php endforeach; ?>
		<div style='clear:both;'></div>
	</div>
	
</div>