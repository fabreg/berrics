<script>
jQuery(document).ready(function($) {
	
	browseFiles('<?php echo $this->Admin->url(array("controller"=>"attach_media","action"=>"browse")); ?>',"#ajax-content");

});

function browseFiles(href,div) {

	$(div).html("<div class='alert'>Loading Media Files ...... </div>").load(href,{},function() {

		attachBehaviors();
		
	});
	
}

function attachBehaviors() {

	$("#ajax-content form").ajaxForm(function(d) { 

		$("#ajax-content").html(d);
		attachBehaviors();
	});
	$("#ajax-content").find("a[rel!=no-ajax]").click(function() { 

		browseFiles($(this).attr("href"),"#ajax-content");
		return false;

	});
	
	$("#ajax-content").find("a[class*=attach-btn]").click(function() { 
		
		attachFile($(this));

		$(this).parent().parent().remove();
		
		return false;
	
	});

	initBootstrap();
}

function attachFile($ele) {

	

	//make hidden field
	var hf = "<input type='hidden' value='"+$ele.attr("data-media-file-id")+"' name='data[AttachMedia][id][]' />";
	
	var thumb = "<img src='"+$ele.attr("data-thumb")+"' border='0'/>";

	var label = "<span class='label label-info'>"+$ele.attr("data-media-type")+"</div>";

	var rm = "<button class='btn btn-danger remove-btn btn-mini' type='button' onclick=\"removeFile('"+$ele.attr("data-media-file-id")+"');\" data-media-file-id='"+$ele.attr("data-media-file-id")+"'>Remove</button>";
	
	var row = $("<tr><td></td><td></td><td></td></tr>");
	
	row.attr({

		"data-media-file-id":$ele.attr("data-media-file-id")

	});

	row.find("td:eq(0)").html(thumb);
	row.find("td:eq(1)").html(label);
	row.find("td:eq(1)").append(hf);
	row.find("td:eq(2)").html(rm);

	$("#attached-files").prepend(row);
	
}

function removeFile($id) {

	$("#attached-files").find("tr[data-media-file-id='"+$id+"']").remove();

}

</script>
<style>
	#attached-files {

		height:100%;
		position:static;
		overflow: auto;
	}
</style>
<div class="page-header">
	<h1>Attach Media Files</h1>

</div>
<div class="row-fluid">
	<div class="span8" id='ajax-content'>
		
	</div>
	<div class="span4" >
		

		<?php echo $this->Form->create('AttachMedia',array(
			"id"=>'AttachMediaForm',
			"url"=>$this->request->here
		));		 ?>
		<h3>Attached Files <button class="btn btn-success btn-mini">Attach Files</button></h3>
		<table cellspacing='0'>
			<thead>
				<tr>
					<th width='1%'>Thumb</th>
					<th>Type</th>
					<th>-</th>
				</tr>
			</thead>
			<tbody id='attached-files'>
				
			</tbody>
		</table>
		<?php echo $this->Form->end(); ?>
	</div>
</div>