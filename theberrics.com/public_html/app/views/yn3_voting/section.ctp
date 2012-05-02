<?php 
if(empty($this->params['section'])) $this->params['section'] = "yn3_voting";
?>
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
							<div class='crew-name-label'>
								CREW NAME
							</div>
							<div class='play-button'>
								<a href='/<?php echo $this->params['section']; ?>/<?php echo $v['Post']['Dailyop']['uri']; ?>'>
									<img border='0' src='/theme/yn3-finals/img/play-video-button.jpg' />
								</a>
							</div>
							<div class='vote-form'>
							<?php if(count($votes)>=3): ?>
								3 VOTES REACHED
								<?php elseif(!array_key_exists($v['YounitedNationsEventEntry']['id'],$votes)): ?>
								<div class='vote-box-form'>
									<?php 
										echo $this->Form->create("YounitedNationsVote",array("url"=>"/".$this->params['section']."/place_vote"));
										echo $this->Form->input("younited_nations_event_entry_id",array("type"=>"hidden","value"=>$v['YounitedNationsEventEntry']['id']));
										echo $this->Form->input("younited_nations_event_id",array("type"=>"hidden","value"=>4));
										echo $this->Form->submit("&nbsp;");
										echo $this->Form->end();
									?>
								</div>
							
								<?php else: ?>
								VOTE PLACED
								<?php endif; ?>
							</div>
						</div>
						<div style='clear:both;'></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class='right-col'>
				<div class='rules-box'>
					<div class='rules1'>
					&bull; Vote now for your top 3 YOUnited Nations videos.<br />
					&bull; Winner will be decided by the amount of votes, a Vans 
					  judging panel, & a Berrics judging panel.<br />
					&bull; Voting ends 5/13/12.
					</div>
					<div class='rules2'>
					&bull; All expense paid trip to the Berrics to film your own 
					  United Nations.<br />
					&bull; Vans for everyone in your crew for a year.<br />
					&bull; A shoot all skaters profile for the winning filmer.<br />
					&bull; A crown with your crew's name engraved in it. <br />
					&bull; A party with the Vans team at the Berrics to celebrate 
					  your win.<br />
					</div>
					<div class='rules3'>
					&bull; Sign in with your facebook profile<br />
					&bull; Select your top 3 by clicking 'PLACE VOTE' on the left.<br />
					&bull; Click 'Submit' after you have selected your top 3.
					
					</div>
				</div>
			</div>
			<div style='clear:both;'></div>
		</div>
	</div>
	<div class='bottom'></div>
</div>