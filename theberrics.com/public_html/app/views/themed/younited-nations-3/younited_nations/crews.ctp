<?php 

$this->Html->script(array("https://maps.googleapis.com/maps/api/js?sensor=true","prettyprint","crews"),array("inline"=>false));
$c = Arr::countries();
?>
<script>
$(document).ready(function() { 

	yn3.init();
	yn3.dropPins();

	$('#check-map').click(function() { 

		var s = 'Zoom:'+yn3.map.getZoom();

		$('.profile-div').html(s);

	});
	
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
		<input type='button' value='Check Map Props' id='check-map'/>
		</div>
	</div>
	<div style='clear:both;'></div>
	</div>
</div>
<?php 

print_r($countries);

?>