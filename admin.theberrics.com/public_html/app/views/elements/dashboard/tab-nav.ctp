<script>
$(document).ready(function() { 

	var uri = "/"+window.location.pathname.substr(1)

	$("#dashboard-tab-nav a").each(function() { 

		var href = $(this).attr("href");

		if(uri == href) {

			$(this).prepend("&#8227;");

		}

	});
	
});
</script>
<div id='dashboard-tab-nav'>
	<ul>
		<li><a href='/dashboard/'>Dailyops</a></li>
		<li><a href='/dashboard/younited_nations'>Younited Nations Uploads</a></li>
		<li><a href='/dashboard/sls'>SLS Qualifying Stats</a></li>
	</ul>
	<div style='clear:both;'></div>
</div>