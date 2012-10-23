
<div class='events-bit'>

	<div class='info'>
		<div class='title'>
			<?php echo $this->Text->truncate($p['Dailyop']['name'],40); ?>
		</div>
		<div class='text-content'>
			<?php 
			
				echo $this->Text->truncate($p['DailyopTextItem'][0]['text_content'],120);
			
			?>
		</div>
		<div class='more-info'>
			<a href='/news/<?php echo $p['Dailyop']['uri']; ?>'>MORE INFO ..</a>
		</div>
		
	</div>
	<div style='clear:both;'></div>
</div>