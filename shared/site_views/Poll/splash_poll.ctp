<?php 


?>
<script>
jQuery(document).ready(function($) {
	
	loadPoll(<?php echo $poll_id ?>);

});

function loadPoll($id) {

	var url = "/poll/splash_poll_ajax/"+$id;

	var div = $("#poll-container");

	var loader = $("#poll-container .loader");

	loader.show();

	$.ajax({
	
		url:url,
		success:function(d) { 
	
			div.html(d);
			loader.hide();

		}

	});

}


</script>
<style>
body {

	background-color:#000;
	background-image:none;

}
#poll-container {

	position: relative;
	height:500px;
	width:600px;
	margin:auto;

}

.loader {

	position: absolute;
	height:100%;
	margin:100%;
	background-image:url(/img/v3/layout/loader-big.gif);
	background-position: center center;
	background-repeat: no-repeat;
	display: none;

}

#poll-description {

	font-size:24px;
	color:white;
	text-align: center;
	padding:15px;
}

#enter {

	text-align: center;
	font-size:32px;

}

#enter a {

	color:#fff;

}
.poll-heading {

	text-align:center;

}
#splash-poll {

	padding-top:15px;

}

</style>
<div id="splash-poll">
	<div id="poll-container">
		<div class="loader"></div>
		
	</div>
</div>
<div id="enter">
	<a href="/dailyops">ENTER THE BERRICS</a>
</div>