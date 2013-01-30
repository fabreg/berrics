<script>

var loading_msg = "<div class='alert'>Loading ..... PLease Wait A Moment</div>";

$(document).ready(function() { 

	

	$("#nav-list a[rel!=noAjax]").click(function() { 

		$("#report-index").html(loading_msg).load($(this).attr("href"),function() { 

			initBootstrap(); 
			formatIndexLinks();


		});

		$('#nav-list .active').removeClass('active');
		
		$(this).parent().addClass("active");
		
		return false;
		
	});

	$("#report-index").html(loading_msg).load("/reports/report_index",function() { });

	
});

function formatIndexLinks() {

	$("#report-index a[rel!=noAjax]").click(function() { 


		$("#report-index").html(loading_msg).load($(this).attr("href"),function() { 

			formatIndexLinks();

			initBootstrap(); 
			
		});

		return false;

		
	});
	
}

</script>
<div class='row-fluid'>
	<div class='span3'>
		<div class='well' style='padding:8px 0;'>
			<ul class='nav nav-list' id='nav-list'>
				<li class='active'>
					<a rel='noAjax' href='/reports' id='home-link' href='<?php echo $this->Admin->url(array("action"=>"index")); ?>'><i class='icon icon-home'></i> Reports Home</a>
				</li>
				<li class='nav-header'>Page Views</li>
				<li>
					<a href='<?php echo $this->Admin->url(array("action"=>"date_overview")); ?>'><i class='icon icon-calendar'></i> Date Overview</a>
				</li>
				<li>
					<a href='<?php echo $this->Admin->url(array("action"=>"url_report")); ?>'><i class='icon icon-calendar'></i> URL Reports</a>
				</li>
				<li class='nav-header'>Video Views</li>
				<li>
					<a href='<?php echo $this->Html->url(array("controller"=>"reports","action"=>"media_date_overview")); ?>'><i class='icon icon-calendar'></i> Date Overview</a>
				</li>
				<li><a href="<?php echo  $this->Html->url(array('action'=>'top_videos'), false); ?>"><i class="icon icon-list-alt"></i> Top Videos</a></li>
				<li><a href="<?php echo $this->Html->url(array('action'=>'video_queue_report'), false); ?>"><i class="icon icon-th-list"></i> Queued Videos Report</a></li>
			</ul>
		</div>
	</div>
	<div class='span9'>
		<div id='report-index'>
			
		</div>
	</div>
</div>