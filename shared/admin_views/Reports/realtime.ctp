<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		getData("videos");
		getData("pages");

	});
	function getData (t) {
		
		var div = $("#realtime-pages");
		var uri = "/reports/realtime_pages";
		switch(t) {

			case 'videos':
				uri = "/reports/realtime_videos";
				div = $("#realtime-videos");
			break;

		}

		var o = {

			url:uri,
			success:function(d) {

				div.html(d);
				initBootstrap();
			}	

		};

		$.ajax(o);

	}
</script>
<div class="page-header">
	<h1>Realtime </h1>
	<a href="/reports/realtime" class="btn btn-primary">Refresh</a>
</div>
<div class="row-fluid">
	<div class="span6" id='realtime-pages'>
		
	</div>
	<div class="span6" id='realtime-videos'>
		
	</div>
</div>