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

}
</script>
<div class="page-header">
	<h1>Attach Brand <small><?php echo $tag['Tag']['name']; ?></small></h1>
</div>
<div id='ajax-content'>
	
</div>