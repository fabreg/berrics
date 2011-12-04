<?php 

$this->Html->script(array("https://maps.googleapis.com/maps/api/js?sensor=true","prettyprint","crews"),array("inline"=>false));
$c = Arr::countries();
?>
<script>
$(document).ready(function() { 

	yn3.init();
	yn3.dropPins();

});


</script>
<style>

#yn3-left-col {

	width:100%;

}
#map {

	height:450px;
	width:100%;
}


#yn3-right-col {

	display:none;

}

#yn3-crews .crew-list {

	background-color:#000;

}



</style>
<div id='yn3-crews'>
	<div style='height:150px;'>

	</div>
	<div id='map'>
	
	</div>
	<div>
	<div class='profile-div'>
	
	</div>
	<div class='crew-list'>
		<div style='width:95%; margin:auto; padding:5px;'>
		<ul>
			<?php foreach($countries as $k=>$v): ?>
				<li>
					<div style="font-weight:bold; font-size:24px; font-family:'Arial'"><?php echo $c[$k]; ?> (<?php echo count($v); ?>)</div>
						<ul style='display:none;'>
					<?php foreach($v as $e): ?>
							<li>
								<?php echo strtoupper($e['YounitedNationsPosse']['name']); ?>
								<div style='font-size:12px; color:#999; font-style:italic;'><?php echo $e['YounitedNationsPosse']['geo_formatted']; ?></div>
							</li>
					<?php endforeach; ?>
						</ul>
				</li>
			<?php endforeach; ?>
		</ul>
		</div>
	</div>
	<div style='clear:both;'></div>
	</div>
</div>
<?php 

print_r($countries);

?>