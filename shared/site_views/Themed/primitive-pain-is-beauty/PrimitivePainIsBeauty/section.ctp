<?php 

if(isset($post)) {

	$title_for_layout = "The Berrics - ".$post['Dailyop']['name']." - ".$post['Dailyop']['sub_title'];

} else {

	$title_for_layout = "The Berrics - PRIMITIVE: PAIN IS BEAUTY";

}

$this->set(compact("title_for_layout"));

?>
<script type="text/javascript">
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
<div id="pain-is-beauty">
	<div class="row-fluid header">
		<div class="span12">
			<img src="/theme/primitive-pain-is-beauty/img/top-heading.jpg" alt="">
		</div>
	</div>
	<?php if (isset($post)): ?>
	<div class="post-view">
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div>
		<img src="/theme/primitive-pain-is-beauty/img/line-break.jpg" alt="">
	</div>
	<?php endif; ?>
	<div class="chapters clearfix">
		<?php foreach ($title['Dailyop'] as $k => $v): ?>
			<div class="chapter-thumb">
				<a href="/primitive-pain-is-beauty/<?php echo $v['uri']; ?>?autoplay" >
					<div class="play-icon"></div>
					<img src="http://img01theberrics.com/images/<?php echo $v['DailyopMediaItem'][1]['MediaFile']['file']; ?>" alt="" border='0' />
				</a>
			</div>
		<?php endforeach ?>
	</div>
	<div>
		<img src="/theme/primitive-pain-is-beauty/img/line-break.jpg" alt="">
	</div>
	<div class='berrics-logo' >
		<img src="/theme/primitive-pain-is-beauty/img/berrics-logo.jpg" alt="">
	</div>
	<div class="load-more">
		<a href="/2013/03/14">
			<img src="/theme/primitive-pain-is-beauty/img/load-more.jpg" alt="">
		</a>
	</div>
</div>