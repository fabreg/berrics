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

border-right:2px dotted #ccc;

}

#banner1 {

	margin:auto;

}


/*

RESPONSIVE SHIT
*/

/* Large desktop */
@media (min-width: 1200px) { 
	
}
 
/* Portrait tablet to landscape and desktop */
@media (min-width: 768px) and (max-width: 979px) { 

#dailyops .left-col {

	
		width:100%;

	}
	
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
	
	$('.dailyops-post,.large-post,div[data-media-file-id]').click(function(e) { 

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

<div class="banner-728" id='banner1'>
	<img src="/img/v3/layout/728-banner.png" alt="" border='0'>
</div>
<?php foreach ($posts as $k => $v): ?>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$v)); ?>
<?php endforeach ?>