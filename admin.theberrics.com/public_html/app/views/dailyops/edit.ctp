<?php 

//reduce tags in to comma seperated string

$tag_array = Set::extract("/Tag/name",$this->data);

$tag_str = implode(",",$tag_array);

//make a select array for the sort order
$sort = array();

for($i=1;$i<=99;$i++) {

	$sort[$i]=$i;

}




?>
<script type='text/javascript'>

var dailyop_id = '<?php echo $this->data['Dailyop']['id']; ?>';

$(document).ready(function() { 


	$( "#DailyopPubDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	$("#DailyopPubTime").timepicker({
	    showPeriod: false,
	    showLeadingZero: false
	});

	//media stuff
	reloadMediaFiles();

	//auto compete data
	$("input[name='data[Meta][key]']").autocomplete({

		source:'/meta/ajax_auto_key/',
		minLength:2

	});

	$("input[name='data[Meta][val]']").autocomplete({

		source:'/meta/ajax_auto_val/',
		minLength:2

	});


	$("#add-meta-form").ajaxForm(function(d) { 
		
		$("#add-meta-form input[type=text]").val('');
		loadMetas();

	});
	
	loadMetas();

	dupe_uri_check();

	$("#check_uri_button").click(function() { 

		dupe_uri_check();

	});

	initEmailTextBlocks();

	$("#DailyopDailyopSectionId").change(function() { 


		initEmailTextBlocks();

	});
	
	
});

function initEmailTextBlocks() {

	if($("#DailyopDailyopSectionId").val() == 15) {

		$(".emotw-field").show();
		

	} else {

		$(".emotw-field").hide();
		
	}

	
}

function loadMetas() {


	$.ajax({

		"url":"/dailyops/ajax_list_metas/"+dailyop_id,
		"success":function(d) {
			
			$("#metas").html(d);
			$("#metas  a").click(function() {

				var id = $(this).attr("rel");
				deleteMetaData(id);
				return false;

			});
		}

	});
	

	
}


function deleteMetaData(id) {

	$.ajax({
		"url":"/dailyops/ajax_remove_meta/"+id,
		"success":function(d) { 
			$('body').append(d);
			loadMetas();
		}
	});
	
}

function reloadMediaFiles() {

	
	$("#media-file-list").css({opacity:.5});
	
	$.get("/dailyops/media_files/"+dailyop_id,function(d) { formatMediaItem(d); });
	
	
}

function formatMediaItem(d) {

	$("#media-file-list").css({opacity:1}).html(d);
	
	$(".media-item dd:even").css({

		"background-color":"#e9e9e9"

	});

	$(".media-item select[name='data[sort_order]']").change(function() { 


		var media_item_id = $(this).parent().parent().parent().parent().parent().find("input[name='data[media_item_id]']").val();

		var display_weight = $(this).val();

		$("#media-file-list").css({opacity:.5});

		alert(media_item_id);
		
		$.get("/dailyops/updateMediaItemWeight/"+media_item_id+"/"+display_weight,function(d) { reloadMediaFiles(d); });
		
	});

	$("#media-file-list a[rel=remove-link]").click(function() { 

		if(confirm("You sure you wanna do this?")) {

			var uri = $(this).attr("href");

			$("#media-file-list").css({opacity:.5});

			$.get(uri,function(d) { 

				reloadMediaFiles(d);

			});
			
		}

		return false;
		
	});

	
	
	
}

function updateSortOrder(media_file_id) {


	
}

function dupe_uri_check() {


	var section_id = $("#DailyopDailyopSectionId").val();

	var uri = $("#DailyopUri").val();
	
	$.ajax({

		"url":"/dailyops/dupe_uri_check/"+dailyop_id+"/"+section_id+"/"+uri,
		"success":function(d) {
			var color = "green";
			var msg = "Uri"
			if(d==0) {
	
				color="red";
				msg="URI (Duplicate Found)";
				
			} 
		 	$("#DailyopUri").parent().find("label").html("<span style='color:"+color+";'>"+msg+"</span>");
		
		}

	});
	
	
}

function handleUserAssignment(data) {

	$("#assigned-users").append("<div>"+data.User.first_name+" "+data.User.last_name+"</div>");

	UserSearch.closeModal();
	
}

function handleVideoUpload() {

	$('form').submit();
	
}


</script>
<style>

.media-item {

	float:left;
	margin:5px;
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
	width:275px;

	
}

.media-item .right table {

	width:100%;
	font-size:11px;
}

.media-item .right table tr td {

	padding:3px;

}

.media-item .right table tr td:first-child {

	font-weight:bold;
	text-align:right;

}

.media-item .right table tr:nth-child(odd) {

	background-color:#e9e9e9;

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
#add-meta-form {

	

}
#add-meta-form div.text {

	float:left;
	width:200px;
	clear:none;
}

#add-meta-form div.submit {

	clear:both;
	
}

#text-items-actions div.submit,.dailyop-text-item div.submit {

	float:left;
	clear:none;
}
.dailyop-text-item  div.textarea textarea {

	width:99%;
	height:330px;

}

.top-checks div.checkbox {

	float:left;
	margin-right:10px;
}

.top-checks div.checkbox label span {

	font-size:10px;
	font-style:italic;

}

</style>
<div class="dailyops form">
<h2>Dailyops Post</h2>
<?php echo $this->Form->create('Dailyop');?>
	<fieldset>
		<legend>Post Settings</legend>
		<div class='top-checks'>
			<?php 
				
				echo $this->Form->input("active",array("label"=>"Active <span>(Activate/Deactivate Post)</span>"));
				echo $this->Form->input("promo",array("label"=>"Promo <span>(Do not show post in related searches)</span>"));
				echo $this->Form->input("hidden",array("label"=>"Hidden <span>(Hide post from main dailyops archive)</span>"));
				echo $this->Form->input("news_post",array("label"=>"News Post <span>(Post is a news post and is handled with care)</span>"));
				echo $this->Form->input("fix_later",array("label"=>"Fix Later <span>(Marker to indicate the shit is fucked and needs to be fixed)</span>"));
				echo $this->Form->input("featured_archive",array("label"=>"Featured Archive <span>(Show post on Dailyops Featured Archive Slot)</span>"));
				echo $this->Form->input("hide_media",array("label"=>"Hide Media <span>(Hide Media Element on Post View)</span>"));
				echo $this->Form->input("slide_show",array("label"=>"Slide Show <span>(Act as a slide show)</span>"));
				echo $this->Form->input("contest_post",array("label"=>"Contest Post <span>(Mark post as a contest)</span>"));
				echo $this->Form->input("display_weight",array("options"=>$sort));
				echo $this->Form->submit("Update");
				
			?>
			<div style='clear:both;'></div>
		</div>
	</fieldset>
	<fieldset>
 		<legend>Edit DailyOp's Post</legend>
 			

		<?php
			if(isset($this->params['pass'][1])) {
				
							echo $this->Form->input("postback",array("type"=>"hidden","value"=>$this->params['pass'][1]));
				
			}
			echo $this->Form->input('id');
		?>
		<div>
		<label>Created By</label>
			<?php echo $this->data['User']['first_name']; ?> <?php echo $this->data['User']['last_name']; ?> ( <?php echo $this->Time->niceShort($this->data['Dailyop']['created']); ?> )
		</div>
		<?php 
		echo $this->Form->input("pub_date",array("type"=>"text","label"=>"Publish Date"));
		echo $this->Form->input("pub_time",array("type"=>"text","label"=>"Publish Time"));
		echo $this->Form->input("theme_override",array("options"=>$themes,"empty"=>true,"label"=>"Theme Override (These are themes that reside on the dev server)"));
		echo $this->Form->input("misc_category",array("options"=>Arr::dailyopsMiscCategories(),"empty"=>true,"label"=>"Misc. Category ( Used for special posts including the news )"));
		echo $this->Form->input('name');
		echo $this->Form->input("sub_title");
		echo $this->Form->input('text_content');
		echo $this->Form->input('html_content');
		echo $this->Form->input('dailyop_section_id');
		echo $this->Form->input("unified_store_id",array("empty"=>true));
		echo "<div style='padding:10px;'>";
		echo $this->Html->link("View On Original Berrics Site","http://www.theberrics.com/dailyopspost.php?postid=".$this->data['Dailyop']['legacy_id'],array("target"=>"_blank"));
		echo "</div>";
		echo $this->Form->input("uri");
		echo "<div style='padding:10px;'><input type='button' value='Check URI' id='check_uri_button' /></div>";
		echo $this->Form->input('Tag',array("type"=>"text","value"=>$tag_str,"label"=>"Tags (Comma sperate each tag)"));
		echo $this->Form->submit("Update");
	?>
	</fieldset>
	
	<fieldset>
		<legend>Linking</legend>
		
		<?php 
			
			
			echo $this->Form->input("url");
			echo $this->Form->input("window_target");
			echo $this->Form->input("link_to_post_url");
			echo $this->Form->submit("Update");
		?>
	</fieldset>
	<fieldset>
		<legend>Episode Options</legend>
		<p>
			If this is the first episode in a series then check "Title Series". 
			<br />This will allow you to attach subsequent episodes to any post checked "Title Episode" 
			<br /><em>** If this is a title episode do not select an option from the drop down</em>
		</p>
		<?php 
			
			echo $this->Form->input("title_episode");
			
			echo $this->Form->input("parent_dailyop_id",array("options"=>$episodes,"empty"=>true));
			
			echo $this->Form->input("episode_display_weight",array("options"=>$sort,"empty"=>false));
			echo $this->Form->submit("Update");
		?>
	</fieldset>
	<a name="text-items"></a>
	<fieldset>
		<legend>Text Items (* For Articles)</legend>
		<div id='text-items-actions'>
		
			<?php 
			
				echo $this->Form->submit("Add New Text-Block",array("name"=>"data[AddNewTextBlock]"));
			
			?>
			<div style='clear:both;'></div>
		</div>
		<div id='text-items'>
			<?php 
				foreach($this->data['DailyopTextItem'] as $key=>$item):
			?>
			<?php 
				
				echo $this->element("dailyops/text-item",compact("key","item"));
				
			?>
			<?php 
				endforeach;
			?>
		</div>
	</fieldset>
	
<fieldset>
		<legend>Media File(s)</legend>
			<div style='padding:10px;'>
				<span class='span-button'><?php echo $this->Admin->attachMediaLink("DailyopMediaItem","dailyop_id",$this->data['Dailyop']['id'],"/dailyops/edit/".$this->data['Dailyop']['id']); ?></span> 
				<span class='span-button'><a href='/media_files/add_blank_file/<?php echo base64_encode($this->here); ?>/dailyop_id:<?php echo $this->data['Dailyop']['id']; ?>'>Attach Blank Media Item</a></span>
			</div>
			<div style='clear:both;'></div>
			<div id='media-file-list'>
				
			</div>
			<div style="clear:both;"></div>
	</fieldset>
		<fieldset>
		<legend>Assign Users</legend>
		<?php 
		
			echo $this->Form->input("AssignedUser",array("options"=>$users,"multiple"=>true));
			echo $this->Form->submit("Update");
		?>
	</fieldset>
<?php 

	echo $this->Form->end();
	
?>
	
	<fieldset>
		<legend>Meta Data</legend>
			<div>
				Attach Additional Data For Filtering Purposes <br />
				(Enter 2 letters to bring up a list of selections)
			</div>
			<div>
		<?php 
		
			echo $this->Form->create("NewMeta",array("url"=>"/dailyops/ajax_add_meta","id"=>"add-meta-form"));
			
			echo $this->Form->input("key");
			
			echo $this->Form->input("val");
			
			echo $this->Form->input("dailyop_id",array("type"=>"hidden","value"=>$this->data['Dailyop']['id']));
			
			echo $this->Form->submit("Add");
			
		?>
			<div id='metas' class='index' style='width:475px;'>
				
			</div>

		</div>
		
	</fieldset>

</div>
<?php 

pr($this->data);

?>
