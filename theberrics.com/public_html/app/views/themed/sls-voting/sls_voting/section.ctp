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
					<div style='text-align:center;'>
						<img border='0' src='/theme/sls-voting/img/grand-prize-heading.jpg' />
					</div>
					<div class='inner'>
						5 People will be entered to win tickets and VIP passes to the street league event of their choice.
						How? Correctly vote for the 5 winners of the selection and you are instanly entered in the drawing.
					</div>
				</div>
				<div class='voting-form'>
					<div style='text-align:center;'>
						<img border='0' src='/theme/sls-voting/img/your-vote-heading.jpg' />
					</div>
					<div class='inner'>
						Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff Voting Stuff 
					</div>
				</div>
			</div>
			<div style='clear:both;'></div>
		</div>
	</div>
</div>