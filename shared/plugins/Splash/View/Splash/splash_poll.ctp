<?php 

$this->set("title_for_layout","POLL JAM");

?>
<script>
jQuery(document).ready(function($) {
	
	loadPoll(<?php echo $poll_id ?>);

});

function loadPoll($id) {

	var url = "/splash/splash_poll_ajax/"+$id+"?<?php echo mt_rand(9999,99999999); ?>";

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

@font-face {
  font-family: 'FuturaWeb';

      src: url('/fonts/futura.eot?') format('eot'),
         url('/fonts/futura.woff') format('woff'),
         url('/fonts/futura.ttf') format('truetype'),
         url('/fonts/futura.svg') format('svg');
}

body {

	background-color:#000;
	background-image:none;

}
#poll-container {

	position: relative;
	width:275px;
	margin:auto;
	font-family: 'FuturaWeb';

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
	margin-bottom: 15px;
}

#enter {

	text-align: center;
	font-size:32px;
	padding-top:30px;
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