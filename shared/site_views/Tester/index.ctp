<?php 

$this->Html->script(array("berrics.video","bin.video"),array("inline"=>false));

?>
<script>

$(document).ready(function() {


	//$(".berrics-html5-video").berricsHtmlPlayer({});
	$(".berrics-html5-video").BerricsVideoPlayer({});
	
});

</script>

<style>


	.berrics-html5-video {
	
		position:relative;
	
	}
	
	.berrics-html5-video video {
	
		margin:auto;
		
	}

	.berrics-html5-video .controls {
		
		position:absolute;
		height:30px;
		bottom:0px;
		width:100%;
		left:0px;
		background-color:#333333;
		font-size:60%;
		cursor:pointer;
	}
	
	.berrics-html5-video .controls .inner {
	
		position:relative;
	
	}
	
	.berrics-html5-video .inner .prog-bar .inner {
	
		position:relative;
	
	}
	
	
	.berrics-html5-video .controls .timer {
	
		position:absolute;
		width:100px;
		right:40px;
		background-color:red;
		text-align:center;
		top:2px;
		
	}
	
	.berrics-html5-video .controls .loaded {
	
		position:absolute;
		width:100px;
		right:40px;
		background-color:green;
		text-align:center;
		top:14px;
	
	}
	
	.berrics-html5-video .controls .playbutton {
	
		height:30px;
		width:50px;
		border-right:1px solid #999999;
		position:absolute;
	}
	
	.berrics-html5-video .controls .inner .prog-bar {
	
		position:absolute;
		left:50px;
		width:678px;
	}
	
	.berrics-html5-video .controls .inner .bar {
	
		position:absolute;
		width:678px;
		height:30px;
		left:17px;
	}
	
	.berrics-html5-video .controls .bar .slider {
	
		height:10px;
		margin-top:10px;
		background-color:#cccccc;
		width:500px;
		
	}
	
	.berrics-html5-video .controls .bar .slider .marker {
	
		width:3px;
		height:10px;
		background-color:black;
		position:absolute;
		
	}
	
	.berrics-html5-video .controls .bar .progress {
	
		background-color:#999999;
	
	}
	

</style>
<div class='berrics-html5-video'>



</div>