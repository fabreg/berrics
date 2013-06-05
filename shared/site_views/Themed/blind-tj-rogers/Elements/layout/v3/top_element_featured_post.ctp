
<script>
	jQuery(document).ready(function($) {
		


				var meta = $("meta[name=viewport]");

		meta.attr({

			"content":"width=1300px, initial-scale=0"

		});


		$("#tj-rogers .post-media-div").trigger('click');

	});
</script>
<?php 

	echo $this->Html->css(array("dailyops"),null,array('inline'=>true));
	
	$Dailyop = ClassRegistry::init("Dailyop");

	$post = $Dailyop->returnPost(array("Dailyop.id"=>7147),1);


?>
<div class="row-fluid" id='tj-rogers'>
	<div id="post-wrapper">
		<div id="post">
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
		<div class="post-text-wrapper">
			<div class="post-text">
				<?php echo $post['Dailyop']['text_content']; ?>
			</div>
		</div>
	</div>
	</div>
	<div class="bottom">
		<a href="https://itunes.apple.com/us/movie/damn-blind-skateboards/id648598069" target='_blank'>
			<img src="/theme/blind-tj-rogers/img/itunes.png" alt="">
		</a>
	</div>
</div>