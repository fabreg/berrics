<script type='text/javascript'>

$(document).ready(function() { 

	browseFiles('<?php echo $this->Admin->url(array("controller"=>"media_files","action"=>"index")); ?>',"#media-browser");

});


function browseFiles(href,div) {

	$(div).html("Loading Media Files....").load(href,{},function() {

		attachBehaviors();
		
	});
	
}

function attachBehaviors() {

	$('form[id!="AttachForm"]').ajaxForm(function(d) { 

		$("#media-browser").html(d);
		attachBehaviors();
	});
	$("#media-browser").find("a[rel!=no-ajax]").click(function() { 

		browseFiles($(this).attr("href"),"#media-browser");
		return false;

	});
	
	$("#media-browser").find("a[class=attach_media]").click(function() { 
	
	
		var id = $(this).attr("media_file_id");

		//alert(id);
		
		attachFile(id);

		$(this).parent().parent().remove();
		
		return false;
	
	});

	initBootstrap();
}

function attachFile(id,thumb) {


	//make hidden field
	var hf = "<input type='hidden' value='"+id+"' name='data[AttachMedia][id][]' />";

	var thumb = $("tr[media_file_id="+id+"] .thumb").html();
	
	var htm = "<div class='media-thumb'>"+thumb+hf+"</div>";
	
	$("#attached-files").append(htm);

	
	
}


</script>
<style>
.media-thumb {

	padding:5px;
	border:1px solid #cccccc;
	margin:5px;
	float:left;

}
</style>
<div class='form'>
	<h2>Attach Files</h2>
	<fieldset>
		<legend>Files to attach</legend>
		<?php echo $this->Form->create("AttachMedia",array("url"=>$this->request->here,"id"=>"AttachForm")); ?>
		<div id='attached-files'>
			
		</div>
		<div style='clear:both;'></div>
		<?php 
		
			echo $this->Form->hidden("model",array("value"=>$this->request->data['model']));
			echo $this->Form->hidden("key",array("value"=>$this->request->data['key']));
			echo $this->Form->hidden("val",array("value"=>$this->request->data['val']));
			echo $this->Form->hidden("post_back",array("value"=>$this->request->data['post_back']));
			
		?>
		<?php echo $this->Form->end("Attach Files"); ?>
	</fieldset>
	<fieldset>
		<legend>Browse File</legend>
		<div id='media-browser'>
		
		</div>
	</fieldset>
</div>