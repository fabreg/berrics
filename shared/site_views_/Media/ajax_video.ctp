<script>
var video = <?php echo json_encode($m); ?>;
var controls = false;
$(document).ready(function() { 

	/*
	'width':video['width'],
		'height':video['height'],
	*/
	controls = true;
	$('.berrics-html5-video').prepend("<video class='berrics-player' id='berrics-player'></video>");
	
	$('.berrics-player').attr({

		"height":500,
		"width":728,
		'type':'video/mp4',
		'src':"http://dev.theberrics.com/files/telegraph_postroll.mp4",
		"autoplay":false
		
	}).bind('ended',function() {

		$('.berrics-player').attr({
			"src":video['brightcove_url'],
			"autoplay":false,
			"poster":"http://img.theberrics.com/?w=728&h=500&zc=1&src=/video/stills/<?php echo $m['file_video_still']; ?>",
			"loop":false
		});

		var e = document.getElementById('berrics-player');
		e.buffered.length = 10;
		controls = true;

	}).bind('timeupdate',function() { 

		var v = $('.berrics-html5-video video');
		
		var t = v.attr("currentTime");

		var duration = v.attr("duration");
	
		var percentPlayed = (t*100)/duration;

		var sliderPixel = Math.ceil((percentPlayed*5));
		
		$(".berrics-html5-video .marker").css({

				"left":sliderPixel+"px"

		});

		//lets setup the timeline timer
		
		var total_min = Math.floor(duration/60);

		var total_seconds = Math.floor(duration-(total_min*60));

		var played_min = 0;

		if(t >=59) {

			played_min = Math.floor(t/60);

		}

		played_seconds = t;

		played_seconds = Math.floor(t-(played_min*60));

		//clean up the seconds 
		
		if(played_seconds < 10) {

			played_seconds = "0"+played_seconds;
			
		}

		if(total_seconds < 10) {

			total_seconds = "0"+total_seconds;
			
		}

		
		$(".timer").html(played_min+":"+played_seconds+" | "+total_min+":"+total_seconds);

		
	}).bind('progress',function() { 

		var v = $('.berrics-html5-video video');

		var e = document.getElementById('berrics-player');

		var buffer = e.buffered;

		var duration = v.attr('duration');

		var buffer_end = buffer.end(0);

		var percentBuffered = (buffer_end*100)/duration;

		//show the progress on the slider
		
		$('.berrics-html5-video .slider .progress').css({

			"width":(percentBuffered*5)+"px",
			"height":"10px"

		});

		$(".berrics-html5-video .controls .loaded").html("Loading:"+Math.round(percentBuffered)+"%");
		
		$("#loaded").html("Loaded: "+percentBuffered);

	}).bind('pause',function() {

		//alert("Pause Event");

	}).bind('play',function() { 

		//alert("Play Event");

	}).bind('stalled',function() { 

		$("#buffer").prepend("Stalled event fired <br />");

	}).bind('canplaythrough',function() { 

		var v = document.getElementById('berrics-player');

		v.play();

		$("#buffer").append("Canplaythrough Event Fired<br />");
		
	}).bind("contextmenu",function() { 

		return false;

	});

	$(".berrics-html5-video").hover(
			function() { 

				if(controls) {

					$(this).find('.controls').fadeIn();
					
				}

			},
			function() { 

				if(controls) {

					$(this).find('.controls').fadeOut();
					
				}

			}
	);

	$(".berrics-html5-video .controls .playbutton").click(function() { 

		var v = document.getElementById("berrics-player");

		if(v.paused == false) {

			v.pause();

			
		} else {

			v.play();
			
		}
		

	});

	//$('.berrics-html5-video .controls .bar .slider .marker').draggable({ containment: 'parent' });

	$('.berrics-html5-video .controls .bar .progress').click(function(e) { 

		var v = document.getElementById("berrics-player");
		
		var offset = $(this).offset();
		
		var x = e.pageX - offset.left;

		var	click_percent = (x*100)/500;

		var goTo = (v.duration*(click_percent/100));

		v.currentTime = goTo;

		v.play();

	});	
	
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
		display:none;
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
	<div class='controls'>
		<div class='inner'>
			<div class='playbutton'>PlayButton</div>
			<div class='prog-bar'>
					<div class='timer'></div>
					<div class='loaded'></div>
					<div class='bar'>
						<div class='slider'>
							<div class='progress'>
								<div class='marker'></div>
							</div>	
							
						</div>
						
					</div>
					<div class='mute'></div>
			</div>
		</div>
	</div>
</div>
<div id='loaded'>

</div>
<div id='buffer'>

</div>