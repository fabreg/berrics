<?php

$this->Unified->mapJsIncludes();


?>
<script>

var map,geocoder = null;
var startLng = '<?php echo (!empty($this->request->data['GeoLocation']['lng'])) ? $this->request->data['GeoLocation']['lng']:'-118.2436849';?>';
var startLat = '<?php echo (!empty($this->request->data['GeoLocation']['lat'])) ? $this->request->data['GeoLocation']['lat']:'34.0522342';?>';
jQuery(document).ready(function($) {
	var latLng = new google.maps.LatLng(startLat, startLng);
 	var mapOptions = {
          center: latLng,
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.HYBRID
        };
        map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);
	
	//drop an initial pin
	//addMarker(latLng);
	
	geocoder = new google.maps.Geocoder();


});
	
</script>
<style>
	body {

		background-image:none;
		background-color:#fff;

	}
</style>
<div id="unified-map">
	<div class="row-fluid">
		<div class="span3">
			aaa
		</div>
		<div class="span9">
			<div id="map_canvas" style='min-height:650px;'></div>
		</div>
	</div>
</div>