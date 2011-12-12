<?php 

$this->Html->script(array("https://maps.googleapis.com/maps/api/js?sensor=true","markerclusterer","infobox","jquery.hashchange","jquery.scrollTo","jquery.form","prettyprint","crews"),array("inline"=>false));
$this->Html->css(array("crews"),"stylesheet",array("inline"=>false));
$c = Arr::countries();

?>
<div id='yn3-crews'>
	<div class='map-bg'>
		<div class='map-bg-container'>
			<div class='map-bg-container-top'>
				<!-- Start Younited nations map -->
				<div class='col-left'>			
					<div class='container'>
						<div class='container-top'>
							<div style='height:78px;'></div>
							<div class='country-list'>
								<ul>
								<?php 
									$i = 0;
									foreach($entries['countries'] as $p=>$v): 
									
									if($i>0 && $p=="UNITED STATES") continue;
									
									if($i==0) {
										
										$country = "UNITED STATES";
										$count = count($entries['countries']['UNITED STATES']);
										
									}  else {
										
										$country = $p;
										$count = count($v);
										
									}
									
									$country = strtoupper($country);
									
								?>
									<li><span class='country-name'><a href='#country:<?php echo $country; ?>'><?php echo $country; ?></span></a><span class='country-count'><?php echo $count; ?></span></li>
								<?php $i++; endforeach; ?>
								</ul>
							</div>
							
						</div>
						
						<div style='clear:both;'></div>
					</div>
					<div class='bottom'>
						
					</div>
				</div>
				<div class='col-right'>
					<div class='map-container'>
						<div id='map'>
							
						</div>
					</div>
					<div class='crew-info'>
						<div class='crew-info-top'></div>
						<div class='crew-info-bg'>
							<div class='crew-content'>
								<?php echo $this->element("younited-nations-3/crew-li"); ?>
							</div>
						</div>
						<div class='crew-info-bottom'></div>
					</div>
					<div style='clear:both;'></div>
				</div>
				<div style='clear:both;'></div>
				<!-- End Younited Nations Map -->
			</div>
			<div style='clear:both;'></div>
		</div>
		<div class='map-bg-bottom'>
		
		</div>
	</div>
</div>