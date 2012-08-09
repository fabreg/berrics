<?php 

$this->Html->script(array("LevisContest","jquery.uploadify-3.1"),array("inline"=>false));

?>
<script>
$(document).ready(function() { 

	var use_base = true;


	$(".task-unpublished").css({
			opacity:.5
		});

	$('.post-bit a').each(function() { 

		$(this).attr("rel","no-ajax");

	});

	$("#levis-511-section a[rel!='no-ajax']").click(function() { 

		var ref = $(this).attr("href");

		if(use_base) ref = Base64.encode(ref);
		
		var state = {};

		state['levis'] = ref;

		$.bbq.pushState(state);

		//document.location.hash = "#!"+ref
		
		return false;
		
	});

	$(window).bind('hashchange',function(e) { 

		var levis = $.bbq.getState('levis') || '';

		if(use_base && levis.length>0) levis = Base64.decode(levis);

		if(levis.length>0 && levis.match(/(levis)/)) {
			
			$.LevisContest('openWindow',{
				'url':levis
			});
			
		} else {

			if($("#LevisOverlay").length>0) {

				$.LevisContest('handleClose');
				$.bbq.removeState("levis");
				
			}

		}
		
	});

	$(window).trigger('hashchange');

	 
	
});
</script>
<div id='levis-511-section'>

	<div class='profile-column'>
		<div>
			<img src='/theme/levis-511-contest/img/rules-top.png' border='0' />
		</div>
		<div class='line-break'>
			
		</div>
		<div>
			<img src='/theme/levis-511-contest/img/signin.png' border='0' />
		</div>
		<div class='line-break'>
			
		</div>
		<div class='text'>
			<div class='heading'>Heading:</div>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sapien tortor, tincidunt sit amet mattis ac, volutpat et ligula. In non dui sed diam suscipit porta ut vestibulum libero. Cras velit velit, vehicula nec pellentesque quis, vehicula tempor diam. Sed at semper purus. Vivamus vestibulum nulla eu quam hendrerit hendrerit faucibus ipsum mollis. Suspendisse potenti. Praesent nisi dui, luctus in dictum nec, laoreet ullamcorper velit. Etiam quis fermentum arcu. Duis facilisis ante vel nunc aliquet posuere. Phasellus vel felis felis, nec imperdiet sem.</p>
		</div>
		
		<div>
			<img src='/theme/levis-511-contest/img/banner1.png' />
		</div>
		<div style='height:15px;'></div>
		<div>
			<img src='/theme/levis-511-contest/img/banner2.png' />
		</div>
		<div class='line-break'>
			
		</div>
		<div class='text'>
			<div class='heading'>Winners?:</div>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sapien tortor, tincidunt sit amet mattis ac, volutpat et ligula. In non dui sed diam suscipit porta ut vestibulum libero. Cras velit velit, vehicula nec pellentesque quis, vehicula tempor diam. Sed at semper purus. Vivamus vestibulum nulla eu quam hendrerit hendrerit faucibus ipsum mollis. Suspendisse potenti. Praesent nisi dui, luctus in dictum nec, laoreet ullamcorper velit. Etiam quis fermentum arcu. Duis facilisis ante vel nunc aliquet posuere. Phasellus vel felis felis, nec imperdiet sem.</p>
		</div>
	</div>
	<div class='task-column'>
		<div class='heading'></div>
		<?php 
			if(isset($post)) {
				
				echo $this->element("dailyops/post-bit",array("dop"=>$post));
				
			} 
			
		?>
		<?php 
			if(isset($image) && !empty($image)): 
			 $ig_data = json_decode($image['MediahuntMediaItem']['instagram_data'],true);
		?>
			<div class='image-view'>
				<div class='image-file'>
					<img border='0' src='http://img.theberrics.com/i.php?src=/mediahunt-media/<?php echo $image['MediahuntMediaItem']['file_name']; ?>&w=275' />
				</div>
				<div class='image-user'>
					<div class='image-task'><span>TASK: </span><?php echo $image['MediahuntTask']['name']; ?></div>
					<div class='image-user'><span>Photo By: </span><?php echo $image['User']['first_name']; ?> <?php echo $image['User']['last_name']; ?></div>
					<?php if($image['MediahuntMediaItem']['instagram_id']): ?>
					<div class='image-instagram-link'><span>Instagram:</span> <a rel='no-ajax' href='<?php echo $ig_data['data']['link']; ?>' target='_blank'><?php echo $ig_data['data']['link']; ?></a></div>
					<?php endif; ?>
					<div class='share-buttons'>
						<div class='twitter'>
							<a rel='no-ajax' href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo "http://theberrics.com/".$_GET['url']; ?>" data-text='<?php echo addslashes($d['name']." ".$d['sub_title']); ?>' data-count="none" data-via="berrics">Tweet</a>
						</div>
						<div class='facebook'>
							<div class="fb-like" data-href="<?php echo urlencode("http://theberrics.com/".$_GET['url']); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" ></div>
						</div> 
						
						
						<div style='clear:both;'></div>
					</div>
				</div>
				<div style='clear:both;'></div>
			</div>
		<?php endif; ?>
		<?php foreach($tasks as $task): ?>
			<?php echo $this->element("task",array("task"=>$task)); ?>
		<?php endforeach; ?>
		<div style='clear:both;'></div>
		<div class='bottom'></div>
	</div>
	<div style='clear:both;'></div>
</div>
