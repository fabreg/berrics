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
			
			var form = $("#DailyopForm");
			
			form.append($("<input />").attr({

				"type":"hidden",
				"value":id,
				"name":"data[Dailyop][user_id]"

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
echo $this->Form->create('Dailyop',array(
	"id"=>'DailyopForm',
	"url"=>$this->request->here
));

echo $this->Form->input("id",array("type"=>"hidden","value"=>$post['Dailyop']['id']));

echo $this->Form->end();

?>
<div class="page-header">
	<h1>Edit Author <small><?php echo $post['Dailyop']['name'];  ?> - <?php echo $post['Dailyop']['sub_title']; ?></small></h1>
</div>
<div id="ajax-content">
	
</div>