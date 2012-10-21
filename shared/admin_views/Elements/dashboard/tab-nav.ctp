<script>
$(document).ready(function() { 

	var uri = "/"+window.location.pathname.substr(1)

	$("#dashboard-tab-nav a").each(function() { 

		var href = $(this).attr("href");

		if(uri == href) {

			$(this).parent().addClass("active");

		}

	});
	
});
</script>
<div id='dashboard-tab-nav'>
	<ul class='nav nav-pills'>
		<li><a href='/dashboard/'>Dailyops</a></li>
		<li><a href='/mediahunt_events/view/2'>Picutre Perfect Contest</a></li>
		<li><a href='/dashboard/canteen'>Canteen Dashboard</a></li>
		<li><a href='/dashboard/reports'>Reports Dashboard</a></li>
		
	</ul>
	<div style='clear:both;'></div>
</div>