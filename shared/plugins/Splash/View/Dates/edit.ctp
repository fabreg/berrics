<script>

$(document).ready(function() { 

	$( "#SplashDatePublishDate").change(function() { 

		var url = "<?php echo $this->Html->url(array("action"=>"edit")); ?>/";

		var date = $(this).val();

		document.location.href=url+date;
		
	}).datepicker({
		"dateFormat":"yy-mm-dd"
	});
	
	$("#creatives").load("<?php echo $this->Html->url(array("plugin"=>"splash","controller"=>"creatives","action"=>"index")); ?>",function() { 

		indexLinking();

		initBootstrap();

	});

	
});

function indexLinking() {

	$("#creatives a[rel!=noAjax]").click(function() { 

		$("#creatives").load($(this).attr("href"),function() { 

			indexLinking(); 

			initBootstrap(); 

			

		});

		return false;

	});

	$("#search-form").ajaxForm(function(d) {

		$("#creatives").html(d);

		indexLinking(); 
		
		initBootstrap();

	});

	$('.attach-button').click(function() { 

		var id = $(this).val();

		var form = $("#date-form");

		form.append($("<input />").attr({
			"type":"hidden",
			"value":id,
			"name":"data[SplashDate][splash_creative_id]"	
		})).submit();

		
	});
	
}

</script>
<div class='page-header'>
	<h1>Edit Splash Date</h1>
	<?php 
	
		$back =  $this->Html->url(array("plugin"=>"splash","controller"=>"dates","action"=>"index"));
	
		if(isset($this->request->params['named']['cb'])) $back = base64_decode($this->request->params['named']['cb']);
		
	?>
	<a href='<?php echo $back; ?>' class='btn btn-primary'>Back To listings</a>
</div>
<div class='row-fluid'>
	<div class='span4'>
		
		
			<?php 
				
				echo $this->Form->create("SplashDate",array("id"=>"date-form"));
				echo $this->Form->input("SplashDate.publish_date",array("type"=>"text","value"=>$date_in)); 
				echo $this->Form->end();
				
				
			?>
		
		<h3>Attached Creatives</h3>
		<hr />
		<div id='staged' class='index'>
			<table cellspacing='0'>
				<tr>
					<th>Page Title</th>
					<th>-</th>
				</tr>
				<?php foreach($dates as $v): ?>
				<tr>
					<td><?php echo $v['SplashCreative']['page_title']; ?></td>
					<td class='actions'>
						<a class='btn btn-danger btn-small' href='<?php echo $this->Html->url(array("action"=>"delete",$v['SplashDate']['id'],"cb"=>base64_encode($this->here))); ?>'><i class='icon icon-white icon-remove'></i> Remove</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
	<div class='span8' id='creatives'>
	
	</div>
</div>