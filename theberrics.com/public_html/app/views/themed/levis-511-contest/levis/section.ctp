<?php 

$this->Html->script(array("LevisContest","jquery.uploadify-3.1"),array("inline"=>false));

$total_tasks = count($tasks);

$total_completed = 0;

if($this->Session->check("Auth.User.id")) {
	
	$comp_check = Set::extract("/MediahuntMediaItem/id",$tasks);
	
	$total_completed = count($comp_check);
	
}


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
			<img src='/theme/levis-511-contest/img/rules-top.jpg' border='0' />
		</div>
		<div class='line-break'>
			
		</div>
		<?php if(!$this->Session->check("Auth.User.id")): ?>
		<div>
			<a href='#BerricsLogin=1'  rel='no-ajax' ><img src='/theme/levis-511-contest/img/signin.png' border='0'/></a>
		</div>
		<div class='line-break'></div>
		<?php endif; ?>
		<div class='text'>
			<div class='heading'>RULES:</div>
			<p>
We will be releasing a new photo challenge every day for 20 days. Go on the hunt and try to complete the photo challenges daily but if you miss some along the way, don't worry. You can sign in anytime and catch up on past challenges at any point during the contest. Once all 20 photo challenges have been announced, you'll have a week to complete the checklist before we close the contest. After that, we'll pick a winner based on the total completion of the checklist and overall creativity of your photos. So get creative, interpret the challenges however you see fit, and have fun with them.			
</p>
			
		</div>
		<div style='height:5px;'></div>
		<div class='text'>
			<div class='heading'>GRAND PRIZE:</div>
			<p>
			All expense paid trip to Los Angeles for private sessions at Nike's Sixth & Mill and The Berrics. The winner will also receive the entire Levi's 511 Skateboard Collection.
			<p>			
		</div>
		<div style='height:5px;'></div>
		<div class='text'>
			<div class='heading'>ADDITIONAL PRIZES:</div>
			<p>
				We'll be giving out some stuff along the way to those who submit the most creative, or funny, or beautiful, or entertaining photos. Basically, if you get us talking about your photo at the office, we'll send you some free stuff!
			</p>			
		</div>
		<div style='height:10px;'></div>
		<div>
			<a href='/<?php echo $this->params['section']; ?>/sixth-and-mill.html' rel='no-ajax'>
				<img src='/theme/levis-511-contest/img/banner1.png' border='0' />
			</a>
		</div>
<div style='height:10px;'></div>
		<div>
			<a href='/<?php echo $this->params['section']; ?>/a-photographic-scavenger-hunt.html' rel='no-ajax'>
				<img src='/theme/levis-511-contest/img/PP_Berrics.jpg' border='0' />
			</a>
		</div>
		
		<div style='height:10px;'></div>
		<div>
			<a href='/<?php echo $this->params['section']; ?>/project-511.html' rel='no-ajax'><img src='/theme/levis-511-contest/img/banner2.png' border='0' /></a>
		</div>
		<div class='line-break'></div>

	</div>
	<div class='task-column'>
		<div class='heading'>
			<div class='count'><span style='color:#cc0033;'><?php echo $total_completed; ?></span> OF <?php echo $total_tasks; ?></div>
		</div>
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
					<div class='image-task'><span>CHALLENGE: </span><?php echo $image['MediahuntTask']['name']; ?></div>
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
		<div style='clear:both; height:72px;'></div>
		<div class='bottom'></div>
	</div>
	<div style='clear:both;'></div>
</div>
