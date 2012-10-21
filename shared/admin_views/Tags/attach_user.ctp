<script type="text/javascript">
jQuery(document).ready(function($) {
	
	
	$("#ajax-content").load("/users/index",function() { 

			handleLinks();

			initBootstrap();

	}).html("<div class='alert'>Loading ..... </div>");


});

function handleLinks () {
	
	

		$("#ajax-content a[rel!=noAjax]").click(function() { 

			var $url = $(this).attr("href");

			$("#ajax-content").load($url,function() { 	

				handleLinks();

				initBootstrap();

				

			}).html("<div class='alert'>Loading ..... </div>");

			return false;

		});

		$("#ajax-content form").ajaxForm({

			"success":function(d) { 

				$("#ajax-content").html(d);

				handleLinks();

				initBootstrap();

			}

		});

		$('.attach-user-btn').click(function (e) {
			
			var $that = $(e.target);

			var id = $that.val();

			var form = $("#TagForm");
			
			form.append($("<input />").attr({

				"type":"hidden",
				"value":id,
				"name":"data[Tag][user_id]"

			})).submit();			

		});


}
</script>
<style type="text/css">
	#ajax-content {


	}

	#ajax-content .page-header {

		display: none;

	}
</style>
<?php 
echo $this->Form->create('Tag',array(
	"id"=>'TagForm',
	"url"=>$this->request->here
));

echo $this->Form->input("id",array("type"=>"hidden","value"=>$tag['Tag']['id']));

echo $this->Form->end();

?>
<div class="page-header">
	<h1>Attach User <small><?php echo $tag['Tag']['name'];  ?></small></h1>
</div>
<div id="ajax-content">
	
</div>