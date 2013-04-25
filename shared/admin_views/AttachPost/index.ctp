<script>
jQuery(document).ready(function($) {
	
	browseFiles('<?php echo $this->Admin->url(array("controller"=>"attach_post","action"=>"browse")); ?>',"#browser");

});

function browseFiles(href,div) {

	$(div).html("<div class='alert'>Loading Posts ...... </div>").load(href,{},function() {

		attachBehaviors();
		
	});
	
}

function attachBehaviors() {

	$("#browser form").ajaxForm(function(d) { 

		$("#browser").html(d);
		attachBehaviors();
	});
	$("#browser").find("a[rel!=no-ajax]").click(function() { 

		browseFiles($(this).attr("href"),"#browser");
		return false;

	});
	
	$("#browser").find("button[class*=attach-btn]").click(function() { 
		
		var id = $(this).attr("data-id");

		attachFile(id);

		$(this).parent().parent().remove();
		
		return false;
	
	});

	initBootstrap();

}


function attachFile($id) {

	var tr = $('table tbody tr[data-id='+$id+']');
	
	var name = tr.attr("data-name");

	var sub = tr.attr("data-sub-title") || "";

	if(sub.length>0) {

		name += "<br /><small><em>"+sub+"</em></small>";

	}

	var post_id = tr.attr("data-id");

	var section = tr.attr("data-section");

	var hf = "<input type='hidden' value='"+post_id+"' name='data[AttachPost][id][]' />";

	var row = $("<tr data-id='"+post_id+"'><td></td><td></td><td></td><td><button class='btn btn-mini btn-danger' onclick='removePost("+post_id+");' data-id='"+post_id+"'>X</button></td></tr>");
	
	row.find("td:eq(0)").html(post_id+hf);
	row.find("td:eq(1)").html(name);
	row.find("td:eq(2)").html(section);

	//append the row

	$("#attached-files").prepend(row);

}

function removePost($id) {

	$("#attached-files").find("tr[data-id='"+$id+"']").remove();

}

</script>
<div class="page-header">
	<h1>Attach Post</h1>
	<a href="<?php echo base64_decode($this->request->params['named']['cb']); ?>" class="btn btn-primary"><i class="icon icon-circle-arrow-left"></i> Back</a>
</div>
<div class="row-fluid">
	<div class="span8" id='browser'>
		
	</div>
	<div class="span4" id='attach-form'>
		<?php echo $this->Form->create('AttachPost',array(
			"id"=>'AttachPostForm',
			"url"=>$this->request->here
		));		 ?>
		<h3>Attached Posts <button class="btn btn-success btn-mini">Attach Posts</button></h3>
		<table cellspacing='0'>
			<thead>
				<tr>
					<th width='1%'>ID</th>
					<th>Name</th>
					<th>Section</th>
					<th>-</th>
				</tr>
			</thead>
			<tbody id='attached-files'>
				
			</tbody>
		</table>
		<?php echo $this->Form->end(); ?>
	</div>
</div>