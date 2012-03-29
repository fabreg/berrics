<?php 

$this->set("title_for_layout","Street League 2012 - The Selection");

$kw = array();

foreach($entries as $e) {
	
	foreach($e['Tag'] as $t) $kw[$t['id']] = $t['name'];

}

$this->set("meta_k",implode($kw,","));

$this->Html->script(array("jquery.cookie.js","section"),array("inline"=>false));

?>
<div id='sls-voting-section'>
	<div class='inner'>
		<?php 
		if(isset($post)) { 
			
			echo $this->element("video-post",array("dop"=>$post));
			
		}
		?>
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
							<?php 
								if(count($votes)>=5):
								elseif(in_array($v['SlsEntry']['id'],$votes)): 
							?>
							
							<div class='vote-placed'>Vote Placed</div>
							
							<?php else: 
								echo $this->Form->create("SlsVote",array("url"=>"/{$this->params['section']}/place_vote"));
								echo $this->Form->input("sls_entry_id",array("type"=>"hidden","value"=>$v['SlsEntry']['id']));
								echo $this->Form->submit("Place Vote",array("div"=>false));
								echo $this->Form->end();
								
								endif; 
							?>
							 
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
						5 People will be entered to win tickets and VIP passes to the <em>Street League 2012</em> event of their choice.
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
<?php 
print_r($votes);
?>