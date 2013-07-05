<script>
	jQuery(document).ready(function($) {
		
		if(!Modernizr.touch) {

			$('.chapter-thumb').hover(
				function() { 
					$(this).find('.play-icon').fadeIn();
				},
				function() { 
					$(this).find('.play-icon').fadeOut();
				}
			);

		}

	});
	handleVideoEnd = function(media_file_id,dailyop_id) {

		//make the ajax request
		var o = {

			url:"/media_service/next_ondemand_post/"+dailyop_id,
			success:function(d) { 

				console.log(d);

				if(d.Dailyop.id) {

					document.location.href = "/"+d.DailyopSection.uri+"/"+d.Dailyop.uri+"?autoplay";

				} else {

					videoEndMethod(media_file_id,dailyop_id);

				}
				

			},
			dataType:"json"

		};

		$.ajax(o);

	}
</script>
<style>
body {
		
	background-image:url(/theme/hold-it-down/img/bg.jpg);
	background-position: center top;

}
#hold-it-down {

	width:900px;
	margin:auto;

}
#player {

	background-image:url(/theme/hold-it-down/img/player.png);
	width:790px;
	height:501px;
	margin:auto;

}

#post .post {

	border:none;

}

#post .post .date,
#post .post .time,
#post .post .post-top h1,
#post .post .post-footer .tags {

	display:none;

}

#post .post .post-top h2 {

	height:42px;
	font-size:24px;
	line-height: 60px;
	font-style: normal;
	color:#fff;
	font-family: 'universcnb';

}
#post .post .post-top h2 a {

	color:#fff;

}
.chapters {

	width:790px;
	margin:auto;

}

.chapter-thumb {

	width:394px;
	float:left;
	text-align: center;
	margin-top:20px;
	position: relative;
	height:270px;
}

.chapter-thumb:nth-child(even) {

	float:right;

}

.chapter-thumb .sub-title {

	background-image:url(/theme/hold-it-down/img/name-bg.png);
	text-align: center;
	color:#fff;
	background-position: center top;
	height:68px;
	background-repeat: no-repeat;
	line-height: 70px;
	font-size: 24px;
	padding-left:8px;
	padding-right:8px;
	font-family: 'universcnb';

}

.post-id-7282 .sub-title {

	font-size:18px;

}

.post-id-7271 .sub-title {

	font-size: 16px;

}

.chapter-thumb .play-icon {

	position: absolute;
	width:100%;
	height:100%;
	background-image:url(/theme/bones-new-ground/img/playbutton-thumb.png);
	background-repeat: no-repeat;
	background-position: center 85px;
	cursor:pointer;
	display:none;

}

.load-more {

	text-align: center;

}

</style>

<div id='hold-it-down'>
	<div class='header'>
		<img src="/theme/hold-it-down/img/heading.png" alt="">
	</div>
	<div id="player">
		<div id="post">
			<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)) ?>
		</div>
	</div>
	<div class="chapters clearfix">
		<?php foreach ($title['Dailyop'] as $k => $v): ?>
			<div class="chapter-thumb post-id-<?php echo $v['id']; ?>">
				
				<a href="/<?php echo $this->request->params['section']; ?>/<?php echo $v['uri']; ?>?autoplay" >
					<div class="play-icon"></div>
					<?php echo $this->Media->mediaThumb(array(

						"MediaFile"=>$v['DailyopMediaItem'][0]['MediaFile'],
						"w"=>340

					)); ?>
				
				
				<div class="sub-title">
					<?php echo strtoupper($v['sub_title']); ?>
				</div>
				</a>
			</div>
		<?php endforeach ?>
	</div>
</div>
<div class="load-more">
	<a href="/2013/07/05">
		<img src="/theme/hold-it-down/img/load.png" border='0' alt="">
	</a>
</div>
<?php 

pr($title);

 ?>