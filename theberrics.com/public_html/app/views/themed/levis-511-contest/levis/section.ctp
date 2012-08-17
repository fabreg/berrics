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
var use_base = true;
$(document).ready(function() { 

	


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
			console.log("Why???");
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

			Picture Perfect is a daily photo challenge anyone can win. It doesn't matter if you skate like PRod or look like Honey Boo Boo Child. Every day, for 20 days, is a new challenge. You can use your phone, your ipad or your old Polaroid camera, it doesn't matter. And if you miss a day, it's okay, you can sign in anytime and catch up. The idea is to just complete the checklist before the contest is over. When it's all said and done we'll pick a winner. But you have to complete the list in order to qualify. The challenges are there for you to interpret however you see fit. Some challenges will be easy, some will be hard, some won't make sense and some will, so get creative, have fun, but most importantly, WIN this grand prize!!!
			</p>
			
		</div>
		<div style='height:5px;'></div>
		<div class='text'>
			<div class='heading'>GRAND PRIZE:</div>
			<p>
			
	All expense paid trip to Los Angeles for private sessions at Nike's Sixth & Mill and The Berrics. The winner will also receive product from the Levi's 511 Skateboard Collection.
			
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

		?>
		<?php echo $this->element("image-view"); ?>
		<?php endif; ?>
		<?php foreach($tasks as $task): ?>
			<?php echo $this->element("task",array("task"=>$task)); ?>
		<?php endforeach; ?>
		<div style='clear:both; height:72px;'></div>
		<div class='bottom'></div>
	</div>
	<div style='clear:both;'></div>
</div>
