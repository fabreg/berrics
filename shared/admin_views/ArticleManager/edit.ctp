<?php

$this->Html->script(array("jquery.elastic"),array("inline"=>false));


$tag_array = Set::extract("/Tag/name",$this->request->data);

$tag_str = implode(",",$tag_array);

?>
<script>
var article_id = <?php echo $this->request->data['Article']['id']; ?>;
var changeMade = false;
var loading_paragraphs = false;
$(document).ready(function() { 
	
	//date pickers
	$( "#ArticlePubDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	$("#ArticlePubTime").timepicker({
	    showPeriod: false,
	    showLeadingZero: false
	});

	
	$("#update-button").click(function() { 
		$(this).val("Updating..... Please Be Patient.....This could take 5 seconds away from your life to complete");
		changeMade = false;
		$("#ArticleParagraphsForm").ajaxSubmit(function() { 

			$("#ArticleDetailsForm").submit();

		});


	});

	loadParagraphs("Loading Text Content.....");

	loadMediaGallery();

	setInterval(function() { 

		$("#ArticleParagraphsForm").ajaxSubmit();
		$("#ArticleDetailsForm").ajaxSubmit();

		var date = new Date();
		$("#auto-save").html("Auto Saved: "+date.toString());
		
	},60000);
	


		
});



function deleteParagraph(paragraph_id) {


	var conf = confirm("Are you sure you want to delete this paragraph?");

	if(conf) {

		loadingMsg("Deleting paragraph...");
		var opt = {
			data:{
				ArticleParagraph:{
					id:paragraph_id
				}
			}
		};
		$.post("/article_manager/ajax_delete_paragraph",opt,function(d) { 
			//alert(d);
			setTimeout(function() { 

				loadParagraphs(".....Loading Updated Content.....");
				changeMade = false;
			},1500);

		});
		
	}
	
}

function updateParagraphs() {

	loadingMsg("Updating Paragraphs");
	$("#ArticleParagraphsForm").ajaxSubmit(function(d) { 
		$("#ArticleDetailsForm").ajaxSubmit();
		setTimeout(function() { 

			loadParagraphs(".....Loading Updated Content.....");
			changeMade = false;
		},1500);
		

	});
	
}

function updateMediaAlign(paragraph_id,align) {

	loadingMsg("Updating Media Alignment..");
	
	var opt = {
		data:{
			ArticleParagraph:{
			
				id:paragraph_id,
				media_align:align
			}
		}
	}
	
	$.post("/article_manager/ajax_update_media_align/",opt,function(d) { 
	
		setTimeout(function() { 

			loadParagraphs(".....Loading Updated Content.....");
			changeMade = false;
		},1500);

	});
	
}

function addParagraph(below) {

	$.get("/article_manager/ajax_new_paragraph/"+article_id+"/"+below+"?cd="+Math.random());
	
	loadParagraphs("Adding New Paragraph....");
	
}


function removeMedia(paragraph_id) {

	loadingMsg("Remove Media File....");
	
	var opt = {

		data:{

			ArticleParagraph:{

				id:paragraph_id

			}

		}

	};
	
	$.post("/article_manager/ajax_remove_media/",opt,function() {

		setTimeout(function() { 

			loadParagraphs(".....Loading Updated Content.....");
			changeMade = false;
		},1500);

	});
	
}

function loadingMsg(msg) {

	$("#ArticleParagraphsForm").prepend(msg);
	$("#ArticleParagraphsForm").css({

		"opacity":.5

	});
	
}

function removeLoadingMsg() {

	$("#ArticleParagraphsForm").css({

		"opacity":1

	});

	
}

function loadParagraphs(msg) {
	
	loadingMsg(msg);
	setTimeout(function() { 

		$.ajax({
			"url":"/article_manager/ajax_load_paragraphs/"+article_id,
			success:function(d) {
			

					$("#ArticleParagraphsForm").html(d);
					removeLoadingMsg();
					$(".paragraph-bit textarea").each(function() { 

						$(this).elastic().focus().blur();

					});

					$(".update-all-paragraphs").click(function() { 

						updateParagraphs();
						
						return false;

					});

					$("a[rel=add-paragraph]").click(function() { 

						var below = $(this).attr("below");
						
						addParagraph(below);
						
						return false;
							
					});

					$("a[rel=remove-media-item]").click(function() { 

						var id = $(this).attr("paragraph_id");

						removeMedia(id);

						return false;

					});
					

					//update media align select
					$("select[class='update-media-align']").change(function() { 

						var id = $(this).attr("paragraph_id");

						var align = $(this).val();

						updateMediaAlign(id,align);
						
					});

					$("a[rel=delete-paragraph]").click(function() { 
	
						var id = $(this).attr("paragraph_id");

						deleteParagraph(id);
						
						return false;

					});

					$('input,textarea,select').change(function() { 

						changeMade = true;
						
					});

					$('.attach-media-link').click(function(){ 

						var a = $(this).find("a");
						
						var link = $(a).attr("href");

						changeMade = false;

						$("#ArticleParagraphsForm").ajaxSubmit(function() { 

							$("#ArticleDetailsForm").ajaxSubmit(function() { 


								document.location.href = link;
								

							});

						});
						
						return false;
						
					});
					
					
			},
			cache:false
		});

	},2000);


	
	
}

function loadMediaGallery() {

	$("#media-gallery").html("Loading Media Items....").load("<?php echo $this->Admin->url(array("action"=>"ajax_load_media_items",$this->request->data['Article']['id'])); ?>",{},function(d) { 

		changeMade = false;
		formatMediaItem();

	});
	
}

function formatMediaItem() {
	
	$(".media-item dd:even").css({

		"background-color":"#e9e9e9"

	});

	$(".media-item select[name='data[sort_order]']").change(function() { 


		var media_item_id = $(this).parent().parent().parent().find("input[name='data[media_item_id]']").val();

		var display_weight = $(this).val();

		$("#media-gallery").html("Updating Media Item....").load("/article_manager/ajax_update_media_item_weight/"+media_item_id+"/"+display_weight,function() { loadMediaGallery(); });
		
	});

	$("#media-gallery a[rel=remove-link]").click(function() { 

		if(confirm("You sure you wanna do this?")) {

			var uri = $(this).attr("href");

			$("#gallery").html("Removing file.....");

			$("#media-gallery").load(uri,function() { 

				loadMediaGallery();

			});
			
		}

		return false;
		
	});
	
	
}

function wrapText(id,type) {

	var ele = document.getElementById(id);

	var start = ele.selectionStart;
	var end = ele.selectionEnd;

	var selection = ele.value.substr(start,(end-start));

	if((start == undefined || end == undefined) ||(end<=start)) {

		alert("You gotta select some text dude-man");
		return false;
		
	}
	

	switch(type) {

		case "anchor":
			var link = prompt("Enter HREF for: "+selection);
			if(link == null || link.length <=0) {

				return alert("Hey dude-man, you gotta enter in a link next time!");
				
			} else {

				selection = "<a href='"+link+"' target='_blank'>"+selection+"</a>";

			}
			
		break;
		case "strong":
			selection = "<strong>"+selection+"</strong>";
		break;
		case "em":
			selection = "<em>"+selection+"</em>";
		break;
		
	
	}

	var tstart = ele.value.substr(0,start);

	var tend = ele.value.substr(end);

	ele.value = tstart+selection+tend;
	
}

function insertAnchor(id) {

	var ele = document.getElementById(id);

	var start = ele.selectionStart;
	var end = ele.selectionEnd;

	var selection = ele.value.substr(start,(end-start));
	
	if((start == undefined || end == undefined) ||(end<=start)) {

		alert("You gotta select some text dude-man");
		return false;
		
	}

	var link = prompt("Enter HREF for :"+selection);

	if(link == null || link.length <=0) {

		return alert("Hey dude-man, you gotta enter in a link next time!");
		
	}

	var tstart = ele.value.substr(0,start);

	var tend = ele.value.substr(end);

	var tag = "<a href='"+link+"' target='_blank'>"+selection+"</a>";

	ele.value = tstart+tag+tend;
	
}


$(window).bind('beforeunload', function() 
        { 
           if(changeMade) {

				return "You are about to leave the page without saving your changes... you sure you wanna do that?";
        	   
           } 
        } 
    );

</script>
<style>
.paragraph-bit {

	padding:5px;
	border:1px solid #cccccc;
	margin-top:15px;
	margin-bottom:15px;
	background-color:#f3f3f3;
	
	
}

.paragraph-bit .paragraph-text {

	width:650px;

}

.paragraph-bit-options {



}

.paragraph-bit-options input {

	padding:10px;

}

#paragraphs {

	position:relative;

}

#paragraphs .loading-msg {

	position:absolute;
	background-color: rgba(00, 00, 00, .5);
	z-index:6000;
	
}

#ArticlePubDate, #ArticlePubTime {

	width:160px;

}
.media-file {
	
	text-align:center;

}

.media-file a {

	font-size:70%;

}

.media-file label {

	font-size:90%;
	text-align:center;

}

.media-file div.text input {

	font-size:75%;
	padding:1px;
}
.video-links {

	font-size:75%;

}
.video-links label {

	font-size:75%;

}

.video-links input {

	font-size:75%;

}




.media-item {

	float:left;
	margin:10px;
	border:1px solid #cccccc;
	-moz-border-radius: 10px;
	border-radius: 10px;
	padding:5px;
	-webkit-box-shadow: 2px 5px 5px #616161;
-moz-box-shadow: 2px 5px 5px #616161;
box-shadow: 2px 5px 5px #616161;
}

.media-item .left {

	float:left;
	

}

.media-item .right {

	float:right;
	width:250px;

	
}

.media-item .right dl {

	font-size:11px;

}

.media-item .right dd {

	line-height:18px;
	height:18px;
	text-indent:3px;
	font-weight:bold;
}

.media-item .right dt {


	margin-left:100px;
	margin-top:-18px;
	height:18px;
	line-height:18px;
}
.ui-button,#paragraphs a {

	border:1px solid #999999;
	background-color:#a0a1a3;
	color:white;
	font-weight:bold;
	font-size:75%;
	padding:8px;
	box-shadow:0px 3px 3px #999999;
	-webkit-box-shadow:0px 3px 3px #999999;
	-moz-box-shadow:0px 3px 3px #999999;
	display:inline-block;
	margin:3px;
	
}

</style>
<?php 

?>
<div class='form' style='width:900px; margin:auto;'>
	<div style=''>
		<?php 
		
			echo $this->Form->create("Article",array("url"=>$this->request->here,"id"=>"ArticleDetailsForm"));
		?>
		<fieldset>
			<legend>Article Details</legend>
			<div id='auto-save'></div>
			<?php 
				
				echo $this->Form->input("id");
				echo $this->Form->input("active");
				echo $this->Form->input("featured");
				echo $this->Form->input("pub_date",array("type"=>"text","label"=>"Publish Date"));
				echo $this->Form->input("pub_time",array("type"=>"text","label"=>"Publish Time"));
				echo $this->Form->input("title");
				echo $this->Form->input("uri");
				echo $this->Form->input("tags",array("value"=>$tag_str,"label"=>"Tags (Multiple tags should be comma seperated)"));
				echo $this->Form->input("summary");
			?>
			<div class='text'>
				<label>Preview Image</label>
				<?php 
				
					if(count($this->request->data['MediaFile'])>0) {
						
						echo $this->Media->mediaThumb(array(
				
							"MediaFile"=>$this->request->data['MediaFile'],
							"w"=>125,
							"h"=>100
						
						));
						
					} else {
						
						echo "Media File Has Not Been Attached";
						
					}
				
				?>
			</div>
			<div class='attach-media-link'>
			<?php echo $this->Admin->attachMediaLink("Article","article_id",$this->request->data['Article']['id'],"/article_manager/edit/".$this->request->data['Article']['id']); ?>
			</div>
			<?php 
				echo $this->Form->input("article_type_id");
				echo $this->Form->input("AberricaCategory",array("options"=>$aberricaCategories,"multiple"=>true,"label"=>"Aberrica Category"));

			?>
		</fieldset>
		<div class='submit'>
			<input type='button' value="Update Article" id='update-button' />
		</div>
		<?php 
			echo $this->Form->end();
		?>
	</div>

	
		<fieldset>
			<legend>Content</legend>
			
			<div id='paragraphs'>
			<?php 
			
				echo $this->Form->create("ArticleParagraphs",array("url"=>array("controller"=>"article_manager","action"=>"ajax_update_paragraphs",$this->request->data['Article']['id']),"id"=>"ArticleParagraphsForm"));
				
				echo $this->Form->end();
			
			?>
			</div>
		</fieldset>
	

		<fieldset>
			<legend>Media Gallery</legend>
			<div class='attach-media-link'>
					<?php echo $this->Admin->attachMediaLink("ArticleMediaItem","article_id",$this->request->data['Article']['id'],"/article_manager/edit/".$this->request->data['Article']['id']); ?> 
			
			</div>
			<div id='media-gallery'></div>
		</fieldset>
	<div style='clear:both;'></div>
</div>