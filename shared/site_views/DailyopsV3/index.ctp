<style type="text/css">
.dailyops-post {

	background-color: #e9e9e9;
	max-width:700px;
	margin:auto;
}
.large-post {

	max-width:1120px;
	margin:auto;

}

#dailyops {

	margin-top:8px;


}

#dailyops .left-col {

	

}
#dailyops .left-col .inner {

	max-width:728px;
	margin:auto;

}
#dailyops .right-col {

	height:100%;
	border-left:1px dotted #ccc;
}

.post-slim {

	border-top:1px solid #000;
	margin-top:5px;
}

.post-slim h2 {

	font-size:18px;
	padding:5px;
	margin:0;
	text-align:center;
	line-height:18px;
	font-family: 'Arial Narrow';

}

.post-slim h3 {

	font-size:14px;
	padding:0;
	margin:0;
	text-align: center;
	line-height: 14px;
	font-family: 'Times New Roman';
	font-style:italic;
	margin-bottom:5px;
}

#body-row {



}

#banner1 {

	margin:auto;

}

#trending-content {

	max-width:300px;
	margin:auto;
}
#trending-content .row-fluid {

	margin:0;
	padding:0;
}

#trending-content .tab-row {

	margin-top:2px;

}

#trending-content .tab-row .span4 {

	margin:0;
	padding:0;
	border:1px solid #000;
}


#trending-content h2 {

	font-family: 'Arial Narrow';
	font-size:22px;
	padding:4px;
	margin:0;
	line-height:22px;
	border-bottom:2px solid #000;

}

/*

RESPONSIVE SHIT
*/

/* Large desktop */
@media (min-width: 1200px) { 
	
}
 
/* Portrait tablet to landscape and desktop */
@media (min-width: 768px) and (max-width: 979px) { 
	
}
 
/* Landscape phone to portrait tablet */
@media (max-width: 767px) {



}
 
/* Landscape phones and down */
@media (max-width: 480px) { 


}

</style>
<script type="text/javascript">
jQuery(document).ready(function($) {
	
	$('.dailyops-post,.large-post').click(function(e) { 

		$(this).videoDiv();
		$(this).unbind('click');

	});
	/*
	$.ajax({
		"url":"/dailyops/ajax_video_play",
		"success":function(d) {

			$("#autoplay").html(d);
			$("#autoplay video").click();
		}
	});
	*/

});
</script>
<div class="row-fluid" id='featured'>
	<div class="span12 ">
		<div class="large-post" data-postid='<?php echo $featured_post['Dailyop']['id']; ?>' data-media-file-id='<?php echo $featured_post['DailyopMediaItem'][0]['MediaFile']['id'] ?>'>
			<img src="/img/v3/layout/large-post.png" alt="">	
		</div>
	</div>
</div>
<div class="row-fluid" id='dailyops'>
	<div class="span8 left-col">
		<div class="inner">
			<div class="banner-728" id='banner1'>
				<img src="/img/v3/layout/728-banner.png" alt="" border='0'>
			</div>
			<?php foreach ($posts as $k => $v): ?>
				<div class="post post-slim">
					<div class="heading">
						<h2><?php echo $v['Dailyop']['name']; ?></h2>
						<?php if (!empty($v['Dailyop']['sub_title'])): ?>
						<h3><?php echo $v['Dailyop']['sub_title']; ?></h3>
						<?php endif ?>
					</div>
					<div class="dailyops-post" data-postid='<?php echo $v['Dailyop']['id']; ?>' data-media-file-id='<?php echo $v['DailyopMediaItem'][0]['MediaFile']['id'] ?>'>
						<img src="/img/v3/layout/post-slim.png" alt="">
					</div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
	<div class="span4 right-col">
		<?php echo $this->element("layout/v3/standard-right-column"); ?>
	</div>
</div>
<div id="autoplay">
	
</div>