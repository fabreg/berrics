<?php 

$this->Html->script("/js/berrics.video.js",array("inline"=>false));


?>
<script>

$(document).ready(function() { 

	var preRoll = false;
	$.getScript('http://ad.doubleclick.net/N5885/pfadx/TESTING/;sz=4x4?t=',function() { 

		if(window.pre != undefined) {

			preRoll = pre;
			
		}

	});

	alert(preRoll);
	
	$("#test").berricsHtmlPlayer({});
	
});

</script>
<div id='test'>


</div>