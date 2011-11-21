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
							<div class='heading'>DETAILS</div>
							<p>
							Show us your crew
							</p>
							<div class='super-list'>	
								<ul>
									<li> Best Crew</li>
									<li> Heshest Crew</li>
									<li> Freshest Crew</li>
									<li> Youngest Crew</li>
									<li> Oldest Crew</li>
									<li> Funniest Crew</li>
									<li> Skatepark Crew</li>
									<li> Tranny Crew</li>
									<li> All-girl crew</li>
									<li> Tom Crews</li>
									<li> I live in BFE and ain't got shit to skate Crew</li>
									<li> I wear nothing but Vans crew</li>
									<li> I ain't afraid to take a slam Crew</li>
									<li> razor scooter hero Crew</li>
									
								</ul>
								<div style='clear:both;'></div>
							</div>
							<p>
								All crew winners, besides Best Crew, will be chosen by The Berrics.
								All winning crew members of the above crew categories will win a year's supply of Vans shoes and limited edition Berrics products. 
								Best Crew will be determined by number of Facebook and Twitter votes received in conjunction with The Berrics upper echelon and Vans team riders. 
								Winner of the Best Crew receives the Younited Nations Grand Prize.
							</p>
							<div class='heading'>GRAND PRIZE</div>
							<div>
								<ul>
									<li> All expense paid trip to The Berrics to film your own United Nations</li>
									<li> Vans for everyone in your crew for a year.</li>
									<li> A Shoot All Skaters profile for the winning filmer.</li>
									<li> A crown with your Crew's name engraved on it. Kind of like the Stanley Cup, but better because that's hockey.</li>
									<li> A party with Vans to celebrate your win.</li>
									<li> Fame. Cuz you know winning isn't worth it unless everyone knows about it.</li>
									<li> Baby Koston's dirty diapers, one for each of you, possibly bronzed.</li>
								</ul>
							</div>
							<div style='clear:both;'></div>
							<p style='font-size:10px; font-style:italic;'>
								Please note: Winning any one of the other crew categories does not mean you can't win the Best Crew category, however, winning the Best Crew category doesn't insure that you will win any of the other categories, but that shouldn't really matter because you won the grand prize and that's more awesome. 
							</p>
							<div class='heading'>RULES</div>
							<div>
								<ul>	
									<li> Crew must be at least 3 people, but no more than 10.</li>
									<li> Any video uploaded to Youtube, Vimeo, facebook or any other video hosting site will be disqualified.</li>
									<li> All entries must be submitted by March 15, 2012.</li>
									<li> All entries must follow the rules listed below.</li>
								</ul>
							</div>
							<div style='clear:both;'></div>
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