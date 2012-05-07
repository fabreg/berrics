<?php 

$voting_closed = false;

foreach($votes as $v) if($v['YounitedNationsVote']['closed']==1) $voting_closed = true;

?>
<script>
var st = 0;
$(document).ready(function() { 
	
	var pre = new Image();
	pre.src = '/theme/sls-voting/img/loading.png';
	
	if( 		
			navigator.userAgent.match(/Android/i)
			 || navigator.userAgent.match(/webOS/i)
			 || navigator.userAgent.match(/iPhone/i)
			 || navigator.userAgent.match(/iPod/i)
			 || navigator.userAgent.match(/BlackBerry/i)
	)
	{
			 
	
		
		
	} else {
	
		//boot strap links
		$('.play-button a').click(function() { 
			
			sc = $(window).scrollTop();
			
			Yn3Video.openVideo($(this).attr("href"));
			
			$(window).scrollTop(sc);
			
			return false;
			
		});
		

		
	}
	
	

	$('form').submit(function() { 
		
		$('input[type=submit]').attr("disabled",true);
		
		return true;
		
	});
	

	
});



var Yn3Video = {
		
		openVideo:function(uri) {
			
			$('body').append("<div id='video-overlay'><div class='inner'><div class='loading'></div></div></div>");
			
			$.ajax({
				
				"url":uri,
				"success":function(d) {
					
					$.ajax({ url: 'http://platform.twitter.com/widgets.js', dataType: 'script', cache:true});
					berricsRelatedVideoScreen = function(media_file_id, dailyop_id) {
						
						Yn3Video.closeVideo();
						
					}
					$('#video-overlay .inner').html(d);
					
					initMediaFileDiv();
					
					$("#video-overlay .inner .yn3-video-post").slideDown('slow',function() { 
						
						$('#video-overlay .dailyop_media_item:eq(0)').click();
						
						//$("#video-overlay").click(function() { Yn3Video.closeVideo(); });
						
						berricsRelatedVideoScreen = function(d,a) {
						
							Yn3Video.closeVideo();
							
						}
						
						
					});
					
				},
				
				
			});
			
			this.handleVideoOverlay();
			
		},
		handleVideoOverlay:function() { 
			
			$('body,html').css({
				
				"overflow":"hidden"
				
			});
			
		},
		closeVideo:function() { 
			
			var sc = $(window).scrollTop();
			
			$('body,html').css({
				
				"overflow":"auto"
				
			});
			
			$("#video-overlay").fadeOut("fast",function() { $("#video-overlay").remove(); });
			
			$(window).scrollTop(sc);
			
		},
		videoOverScreen:function(m_id,d_id) {
			
			var post_div = $('.d-post-bit[dailyop_id='+d_id+']').parent();
			
			var form_div = $('.entry-div[dailyop_id='+d_id+']').clone();
			
			
			$(post_div).html($(form_div));
			
		}
		
		
}
</script>
<?php 
if(empty($this->params['section'])) $this->params['section'] = "yn3_voting";
?>
<div id='yn3-voting'>
	<?php if(isset($post)): ?>
	<div class='post' style='width:728px; margin:auto;'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<?php endif; ?>
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
								
								<?php elseif(!array_key_exists($v['YounitedNationsEventEntry']['id'],$votes)): ?>
								<div class='vote-box-form'>
									<?php 
										echo $this->Form->create("YounitedNationsVote",array("url"=>"/".$this->params['section']."/place_vote"));
										echo $this->Form->input("younited_nations_event_entry_id",array("type"=>"hidden","value"=>$v['YounitedNationsEventEntry']['id']));
										echo $this->Form->input("younited_nations_event_id",array("type"=>"hidden","value"=>4));
										echo $this->Form->submit(" ");
										echo $this->Form->end();
									?>
								</div>
							
								<?php else: ?>
									<div class='vote-placed-div'><img border='0' src='/theme/yn3-finals/img/vote-placed-button.jpg' /></div>
								<?php endif; ?>
							</div>
						</div>
						<div style='clear:both;'></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class='right-col'>
				<div class='rules-box'>
					<div style='height:85px;'></div>
					<div style='text-align:center;'>
						<img border='0' src='/theme/yn3-finals/img/yn3.jpg' />
					</div>
					<div class='rules1'>
					<ul>
					<li> Vote now for your top 3 YOUnited Nations videos.</li>
					<li> Winner will be decided by the amount of votes, a Vans 
					  judging panel, & a Berrics judging panel.</li>
					<li> Voting ends 5/13/12.</li>
					</ul>
					</div>
					<div style='text-align:center;'>
						<img border='0' src='/theme/yn3-finals/img/grand-prize.jpg' />
					</div>
					<div class='rules2'>
					<ul>
					<li> All expense paid trip to the Berrics to film your own 
					  United Nations.</li>
					<li> Vans for everyone in your crew for a year.</li>
					<li> A shoot all skaters profile for the winning filmer.</li>
					<li> A crown with your crew's name engraved in it. </li>
					<li> A party with the Vans team at the Berrics to celebrate 
					  your win.</li></ul>
					</div>
					<div style='text-align:center;'>
						<img border='0' src='/theme/yn3-finals/img/how-to-vote.jpg' />
					</div>
					<div class='rules3'>
					<ul>
					<li> Sign in with your facebook profile</li>
					<li> Select your top 3 by clicking 'PLACE VOTE' on the left.</li>
					<li> Click 'Submit' after you have selected your top 3.</li>
					</ul>
					</div>
					<div id='user-vote-box'>
					<?php if($this->Session->check("Auth.User.id")): ?>
					<div class='user-logged-in'>
						Logged in as: <?php echo $this->Session->read("Auth.User.email"); ?>
					</div>
					<?php endif; ?>
					<?php 
						$vote_rows = array();
						
						foreach($votes as $v) $vote_rows[] = $v;
						
						for($i=0;$i<3;$i++): 
						
					?>
						<?php 
							if(isset($vote_rows[$i])): 
							
							$vote_row = false;
							foreach($entries as $v) if($vote_rows[$i]['YounitedNationsVote']['younited_nations_event_entry_id'] == $v['YounitedNationsEventEntry']['id']) $vote_row = $v;
						?>
						<div class='vote-row'>
							<div class='vote-row-thumb'>
								<?php echo $this->Media->mediaThumb(array(
																	"MediaFile"=>$vote_row['Post']['DailyopMediaItem'][1]['MediaFile'],
																	"w"=>50,
																	"h"=>50
								)); ?>
							</div>
							<div class='vote-row-crew'>
								<?php echo $this->Media->mediaThumb(array(
								"MediaFile"=>$vote_row['Post']['DailyopMediaItem'][2]['MediaFile'],
								"h"=>40
							)); ?>
							</div>
							
							<?php if(!$voting_closed): ?>
							<div class='remove-div'>
								<?php 
									echo $this->Form->create("YounitedNationsVote",array("url"=>"/younited-nations-3/remove_vote"));
									echo $this->Form->input("id",array("type"=>"hidden","value"=>$vote_rows[$i]['YounitedNationsVote']['id']));
									echo $this->Form->submit("Remove");
									echo $this->Form->end();
								?>
							</div>
							<?php endif; ?>
							<div style='clear:both;'></div>
						</div>
						<?php else: ?>
						<div class='blank-vote'>
							<div class='vote-row-thumb'>
								<img border='0' src='/theme/yn3-finals/img/no-vote.jpg' />
							</div>
							<div class='vote-row-crew'>
							
							</div>
							<div style='clear:both;'></div>
						</div>
						<?php endif;?>
					<?php endfor; ?>
					<div class='submit-entries-div'>
						<?php if(count($votes)>=3): ?>
							<?php if($voting_closed): ?>
								YOUR VOTE HAS BEEN ACCEPTED
							<?php else: ?>
								<?php 
									echo $this->Form->create("YounitedNationsVote",array("url"=>"/younited-nations-3/close_votes"));
									echo $this->Form->submit(" ");
									echo $this->Form->end();
								?>
							<?php endif; ?>
						<?php else: ?>
							SELECT YOUR CREWS TO THE LEFT
						<?php endif; ?>
					</div>
				</div>
				</div>
				<div>
					<img border='0' src='/theme/yn3-finals/img/sam-dawg.jpg' />
				</div>
			</div>
			<div style='clear:both;'></div>
		</div>
	</div>
	<div class='bottom'></div>
</div>