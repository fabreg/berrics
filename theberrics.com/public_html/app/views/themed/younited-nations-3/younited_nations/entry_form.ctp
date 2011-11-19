<?php 

$this->Html->script(array("https://maps.googleapis.com/maps/api/js?sensor=true","entry_form"),array("inline"=>false));


?>
<div id='younited-nations-entry'>
	<div class='entry-form-div'>
		<div class='inner'>
			<div class='yn3-container'>
				<div class='yn3-container-top'>
					<?php echo $this->Form->create("YounitedNationsEntry",array("url"=>$this->here));?>
					<div class='form-content'>
						<div class='rules'>
							<div class='heading'>DETAILS</div>
							<p>	
								You've been stacking clips for months…  You've mastered your video editing software...  You have the tightest crew around...  Well, now's your chance to show everyone just how bad ass your crew really is.  YOUnited Nations is a contest that gives you the platform to showcase the talents and personality of your crew to the entire planet.  All you need to do is submit a video of what you and your friends do naturally; skate, be creative, and have fun.  The winner will be decided by the number of Facebook and Twitter votes in conjunction with a panel of Berrics staff and Vans riders.
							</p>
							<p>
							In addition to the grand winner, this time around we've added some 'Special Awards'.  We are looking to hook up the heshest crew, the freshest crew, the youngest crew, the oldest crew, the funniest crew, as well as a skatepark crew, a transition crew, an all Vans-wearing crew, the most remote crew, and an all-girl crew.
							</p>
							<div class='heading'>RULES</div>
							<p>
							A crew must contain at least 3 people, but no more than 10.  Any video that is uploaded to youtube, vimeo, facebook, or any other video hosting site will be disqualified.  All entries must adhere to the video requirements listed below.  Submit entry form and video by March 15, 2012.
							</p>
						</div>
						<div id='entry-form'>
							<div class='form-header'>
								
							</div>
							<div class='inner'>
								<?php 
								
									echo $this->element("younited-nations-3/crew-info-form");
									echo $this->element("younited-nations-3/crew-roster-form");
									echo $this->element("younited-nations-3/crew-file-upload");
										
								?>
							</div>
						</div>
					</div>
					<?php echo $this->Form->end(); ?>
					
				</div>
				<div style='clear:both;'></div>
			</div>
		</div>
	</div>
	<div></div>
	<div style='clear:both;'></div>
</div>