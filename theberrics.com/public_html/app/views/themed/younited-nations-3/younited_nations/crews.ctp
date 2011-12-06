<?php 

$this->Html->script(array("https://maps.googleapis.com/maps/api/js?sensor=true","markerclusterer","prettyprint","crews"),array("inline"=>false));
$c = Arr::countries();
?>
<script>



</script>
<style>

#yn3-left-col {

	width:100%;

}

#map {
	margin-top:35px;
	height:400px;
	width:100%;
	
}

#yn3-right-col {

	display:none;

}

#yn3-crews .crew-list {

	background-color:#000;

}

#yn3-crews .col-right {

	float:right;
	width:77%;
	clear:none;
}

#yn3-crews .col-right .inner {

	padding:10px;
	
}

#yn3-crews .col-left {

	float:left;
	width:20%;
	clear:none;
}

</style>
<div id='yn3-crews'>
	<div class='col-left'>
		<div class='country-menu'>
			
				<?php foreach($entries['countries'] as $p=>$v): ?>
				
						<?php echo $p; ?>
					
				<?php endforeach; ?>
			
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
</div>
