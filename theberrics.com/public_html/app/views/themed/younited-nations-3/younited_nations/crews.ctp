<?php 

$this->Html->script(array("https://maps.googleapis.com/maps/api/js?sensor=true","markerclusterer","prettyprint","crews"),array("inline"=>false));
$this->Html->css(array("crews"),"stylesheet",array("inline"=>false));
$c = Arr::countries();

?>
<div id='yn3-crews'>
	<div class='map-bg'>
		<div class='map-bg-container'>
			<div class='map-bg-container-top'>
				<!-- Start Younited nations map -->
				<div class='col-left'>
					<div class='country-menu'>
						<ul>
						<?php foreach($entries['countries'] as $p=>$v): ?>
							<li><?php echo $c[$p]; ?></li>
						<?php endforeach; ?>
						</ul>
					</div>
				</div>
				<div class='col-right'>
					<div class='inner'>
						<div id='map'>
							
						</div>
					</div>
					<div style='height:800px;'></div>
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