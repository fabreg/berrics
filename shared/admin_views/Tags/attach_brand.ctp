<script type="text/javascript">
jQuery(document).ready(function($) {
	

	$("#ajax-content").load("/brands/index",function() { 


		formatLinks();

		initBootstrap();

	});


});

function formatLinks() {

	$("#ajax-content a[rel!=noAjax]").click(function() { 

		var ref = $(this).attr("href");

		$("#ajax-content").load(ref,function() { 

			formatLinks();

			initBootstrap();

		});

		return false;

	});

	$('#ajax-content form[rel!=noAjax]').ajaxForm(function(d)  { 

		$("#ajax-content").html(d);

		formatLinks();

		initBootstrap();

	});

	//bind the attach brand btn

	$(".attach-brand-btn").click(function() { 

		var val = $(this).val();

		var $form = $("#TagForm");

		$form.append(
			$("<input type='hidden' name='data[Tag][brand_id]'/>").attr("value",val)
		);

		$form.submit();


	});

}
</script>
<div class="page-header">
	<h1>Attach Brand <small><?php echo $tag['Tag']['name']; ?></small></h1>
</div>
<?php 

	echo $this->Form->create('Tag',array(
		"id"=>'TagForm',
		"url"=>$this->request->here
	));
	echo $this->Form->input("id",array("type"=>"hidden","value"=>$tag['Tag']['id']));
	echo $this->Form->end();

?>
<div id='ajax-content'>
	
</div>