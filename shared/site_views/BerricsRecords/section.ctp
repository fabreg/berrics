
<script>

var upload = {};
$(document).ready(function() { 


	$('.badge').each(function() { 

		$(this).prepend("<div class='overlay'></div>");

		$(this).find('.overlay').css({

			"position":"absolute",
			"height":"124px",
			"width":"312px",
			"cursor":"pointer"
			
		}).click(function() { 
			var ref = $(this).parent().find("a").attr("href");
			document.location.href = ref;
		});

		if($(this).attr("current_record")!=1) {

			$(this).find('.overlay').addClass("failed");
			
		}
		
	});

	
});
</script>
<div id='for-the-record-section'>
	
	<?php 
		if(isset($post)) {
			
			echo $this->element("dailyops/post-bit",array("dop"=>$post));
			echo $this->element("banner-placements/dops-post-bottom");
			echo "<div style='height:15px;'></div>";
		}
	?>
	<?php foreach($records as $k=>$record): ?>
	<div class='record-plaq'>
		<div class='plaq-top'>
			
		</div>
		<div class='plaq-heading'>
					<div class='inner'><?php echo strtoupper($record['BerricsRecord']['record_name']); ?></div>
					<div class='challenge-link'>
						
						<a href='/identity/login/send_to_facebook/<?php echo base64_encode("/for-the-record/challenge/".base64_encode($record['BerricsRecord']['id'])); ?>'>&gt;&gt; CLICK HERE TO CHALLENGE THE RECORD &lt;&lt;</a>
						
					</div>
		</div>
		<div class='plaq-heading-bottom'></div>
		<div class='plaq-body'>
				<div class='inner'>
				<?php foreach($record['BerricsRecordsItem'] as $item):?>
					<div class='badge' current_record='<?php echo $item['current_record']; ?>'>
						<div class='name'><a href='/<?php echo $item['Post']['DailyopSection']['uri']; ?>/<?php echo $item['Post']['Dailyop']['uri']; ?>?autoplay'><?php echo strtoupper($item['User']['first_name']); ?> <?php echo strtoupper($item['User']['last_name']); ?></a></div>
						<div class='result-label'><?php echo strtoupper($item['result_label']); ?></div>
						<div class='date'><?php echo strtoupper(date('M jS, Y',strtotime($item['Post']['Dailyop']['publish_date']))); ?></div>
					</div>
				<?php endforeach;?>	
				</div>
				<div style='clear:both;'></div>
		</div>
		<div class='plaq-bottom'>
		
		</div>

	</div>
	<?php 
		if(!isset($post) && $k==0):
	?>
	<?php echo $this->element("banner-placements/dops-post-bottom");?>
	<div style='height:15px;'></div>
	<?php endif; ?>
	<?php endforeach; ?>
</div>