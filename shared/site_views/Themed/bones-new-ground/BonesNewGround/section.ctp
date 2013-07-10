<?php 

if(isset($post)) {

	$title_for_layout = "The Berrics - ".$post['Dailyop']['name']." - ".$post['Dailyop']['sub_title'];

} else {

	$title_for_layout = "The Berrics - BONES NEW GROUND";

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
<div id="bones-new-ground">
	<div class="row-fluid header">
		<div class="span3 hidden-phone">
			<img src="/theme/bones-new-ground/img/bones-logo.png" alt="" />
		</div>
		<div class="span6">
			<a href='/bones-new-ground/download' target='_blank'><img src="/theme/bones-new-ground/img/new-ground-logo.png" alt="" border='0' /> </a>
		</div>
		<div class="span3 hidden-phone">
			<img src="/theme/bones-new-ground/img/berrics-logo.png" alt="" />
		</div>
	</div>
	<?php if (isset($post)): ?>
	<div class="post-view">
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<img src="/theme/bones-new-ground/img/lb.png" alt="">
	<?php endif; ?>
	<div class="chapters clearfix">
		<?php foreach ($title['Dailyop'] as $k => $v): ?>
			<div class="chapter-thumb">

				<a href="/bones-new-ground/<?php echo $v['uri']; ?>?autoplay" >
					<div class="play-icon"></div>
					<img src="http://img01theberrics.com/images/<?php echo $v['DailyopMediaItem'][1]['MediaFile']['file']; ?>" alt="" border='0' />
				</a>
			</div>
		<?php endforeach ?>
	</div>
	<div class="load-more">
		<a href="/2013/02/14">
			<img src="/theme/bones-new-ground/img/load-more-posts.png" alt="">
		</a>
	</div>
</div>