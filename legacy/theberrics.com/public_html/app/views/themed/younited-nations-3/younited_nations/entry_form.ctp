<?php 

$this->Html->scriptStart(array("inline"=>false));
?>
var upload_uri = "/younited-nations-3/handle_upload/<?php echo $this->Session->id(); ?>/";
<?php
$this->Html->scriptEnd();

$js = array(
	"https://maps.googleapis.com/maps/api/js?sensor=true",
	"jquery.form",
	"swfupload",
	"entry_form"
);
$this->Html->script($js,array("inline"=>false));


?>
<div id='younited-nations-entry'>
	<div class='entry-form-div'>
		<div class='inner'>
			<div class='yn3-container'>
				<div class='yn3-container-top'>
					<?php echo $this->Form->create("YounitedNationsEventEntry",array("url"=>$this->here,"id"=>"YounitedNationsEventEntryForm"));?>
					<div class='form-content'>
						<div class='rules'>
						<div style='text-align:center;'>
							<img src='/theme/younited-nations-3/img/show-us-your-crew.png' alt='' border='0' />
						</div>
						<hr />
						<div class='super-list'>	
								<ul>
									<li> <strong>Best Crew</strong></li>
									<li> Heshest Crew</li>
									<li> Freshest Crew</li>
									<li> Youngest Crew</li>
									<li> Oldest Crew</li>
									<li> Skatepark Crew</li>
									<li> Tranny Crew</li>
									<li> All-girl crew</li>
								</ul>
								<div style='clear:both;'></div>
							</div>
						
						<hr />
							
							<p>
								All crew winners, besides Best Crew, will be chosen by The Berrics. All Winning crew members will win Vans shoes and Berrics products.
							</p>
							<p>
							Best Crew will be determined by number of Facebook and Twitter votes received in conjunction with a Berrics and Vans team rider panel. Winner of the Best Crew receives the Younited Nations Grand Prize.
							</p>
							<div class='heading'>GRAND PRIZE</div>
							<div>
								<ul>
									<li> All expense paid trip to The Berrics to film your own United Nations</li>
									<li> Vans for everyone in your crew for a year.</li>
									<li> A Shoot All Skaters profile for the winning filmer.</li>
									<li> A crown with your Crew's name engraved on it.</li>
									<li> A party with Vans to celebrate your win.</li>
									<li> Fame.</li>
									
								</ul>
							</div>
							<div style='clear:both;'></div>
							<div class='heading'>RULES</div>
							<div>
								<ul>	
									<li> Crew must be at least 3 people, but no more than 10.</li>
									<li> Any video or footage already uploaded to the internet will not be eligible for Grand Prize.</li>
									<li> All entries must be submitted by March 15, 2012.</li>
									<li> Sign up today and enter to win Vans shoes for your whole crew (video not required to enter).</li>
								</ul>
							</div>
							<div style='clear:both;'></div>
							<div class='signup-now'>SIGN UP NOW FOR YOUR CHANCE TO WIN SOME FREE SHOES FROM VANS!</div>
						</div>
						<div id='entry-form'>
							<div class='form-header'>
								
							</div>
							<div class='inner'>
								<div class='form-msg'>
								
								</div>
								<?php 
									echo $this->element("younited-nations-3/facebook-login-large");
									echo $this->element("younited-nations-3/crew-info-form");
									echo $this->element("younited-nations-3/crew-roster-form");
									echo $this->element("younited-nations-3/crew-file-upload");				
								?>
								<div style='height:80px;'></div>
							</div>
							
						</div>
					</div>
					
					<?php 	
							echo $this->Form->input("YounitedNationsEvent.id",array("type"=>"hidden","value"=>$event_id));
							if(isset($this->data['YounitedNationsEventEntry']['id'])) echo $this->Form->input("YounitedNationsEventEntry.id");
							if(isset($this->data['YounitedNationsPosse']['id'])) echo $this->Form->input("YounitedNationsPosse.id");
							echo $this->Form->end(); 
					?>
					
				</div>
				
				<div style='clear:both;'></div>
			</div>
			<img src='/theme/younited-nations-3/img/form-bottom.png' alt='' border='0' />
		</div>
	</div>
	<div></div>
	<div style='clear:both;'></div>
</div>
<input type='hidden' id='hidden_input_clone' />
<?php pr($this->data); ?>