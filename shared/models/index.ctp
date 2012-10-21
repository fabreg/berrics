<script>
$(document).ready(function() { 

	
	
});


function loadDailyops() {

	var date = arguments[0] || '';

	$("#dailyops").load('<?php echo $this->Html->url(array("controller"=>"dashboard","action"=>"dailyops")); ?>'
						{
							"data":{
									"Dailyops":{
										"start_date":date
									}
								}
							},
						function(d) {

							initBootstrap();

						}
						)
	
}

</script>
<style>

</style>
<div class='page-header'>
	<h2>Dashboard</h2>
</div>
<div class='row-fluid'>
	<div class='span6'>
		<div id='dailyops'>
		
		</div>
	</div>
	<div class='span6'></div>
</div>