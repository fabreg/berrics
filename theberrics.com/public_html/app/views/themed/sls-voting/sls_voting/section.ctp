<?php 

$this->Html->script(array("jquery.cookie.js","section"),array("inline"=>false));

?>
<div id='sls-voting-section'>
	<div class='inner'>
		<div class='voting-heading'></div>
		<div class='vote-section'>
			<div class='entries'>
				<div>
					<img border='0' src='/theme/sls-voting/img/selection-heading.png' />
				</div>
				<div class='entry-div-wrapper'>
				<?php foreach($entries as $v): ?>
					<div class='entry-div' style='background-image:url(http://img.theberrics.com/images/<?php echo $v['DailyopMediaItem'][1]['MediaFile']['file']; ?>);'>
						<div class='play-button'>
							<a href='/<?php echo $this->params['section']; ?>/<?php echo $v['Dailyop']['uri']; ?>'>Play Video</a>
						</div>
						<div class='vote-button'>
							Place Vote
						</div>
					</div>
					<div class='entry-spacer'></div>
				<?php endforeach; ?>
				</div>
			</div>
			<div class='voting'>
				<div class='rules'>
					<div style='text-align:center;'>
						<img border='0' src='/theme/sls-voting/img/rules-heading.jpg' />
					</div>
					<div class='inner'>
						Rules Blah Blah Rules Blah Blah Rules Blah Blah Rules Blah Blah Rules Blah Blah Rules Blah Blah Rules Blah Blah Rules Blah Blah Rules Blah Blah 
					</div>
				</div>
				<div class='voting-form'>
				
				</div>
			</div>
			<div style='clear:both;'></div>
		</div>
	</div>
</div>