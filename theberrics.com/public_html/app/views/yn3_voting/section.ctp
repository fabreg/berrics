<div id='yn3-voting'>
	<div class='voting-top'>
	
	</div>
	<div class='content'>
		<div class='inner'>
			<div class='left-col'>
				<div>
					<img border='0' src='/theme/yn3-finals/img/voting-main-header.jpg' />
				</div>
				<?php foreach($entries as $v): ?>
					<div class='vote-div'>
						<div class='thumb'>
							<?php 
								echo $this->Media->mediaThumb(array(
									"MediaFile"=>$v['Post']['DailyopMediaItem'][1]['MediaFile'],
									"w"=>102
								));
							?>
						</div>
						<div class='info'>
							<div class='crew-name-img'>
								<img border='0' src='http://img.theberrics.com/images/<?php echo $v['Post']['DailyopMediaItem'][2]['MediaFile']['file']; ?>' />
							</div>
							<div class='crew-name'>
								CREW NAME
							</div>
							<div class='play-button'>
								<a href='/younited-nations-3/<?php echo $v['Post']['Dailyop']['uri']; ?>'>PLAY VIDEO</a>
							</div>
							<div class='vote-form'>
								<?php if(!array_key_exists($v['YounitedNationsEventEntry']['id'],$votes)): ?>
								FORM
								<?php else: ?>
								ALREADY VOTED
								<?php endif; ?>
							</div>
						</div>
						<div style='clear:both;'></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class='right-col'>
			
			</div>
			<div style='clear:both;'></div>
		</div>
	</div>
	<div class='bottom'></div>
</div>