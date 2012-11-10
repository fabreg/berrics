<script type="text/javascript">
jQuery(document).ready(function($) {
	
	getYoutube();

});

function getYoutube() {
	
	$("#youtube").load(
		"/dailyops/ajax_list_youtube?t=1"
	).html("<div class='alert'>Loading Youtube Videos</div>");

}

</script>
<div class="page-header">
	<h1>Dailyops Sharing</h1>
</div>
<div class="row-fluid">
	<div id='youtube' class="span6">
		
	</div>
	<div class="span6"></div>
</div>