<?php

$this->Unified->mapJsIncludes();


?>
<script>
//var markersJson = <?php echo json_encode($stores); ?>;
var map,geocoder = null;
var startLng = '<?php echo (!empty($this->request->data['GeoLocation']['lng'])) ? $this->request->data['GeoLocation']['lng']:'-118.2436849';?>';
var startLat = '<?php echo (!empty($this->request->data['GeoLocation']['lat'])) ? $this->request->data['GeoLocation']['lat']:'34.0522342';?>';
var markers = [];
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
	
	<?php foreach($stores as $store): ?>
		<?php if(empty($store['GeoLocation']['lat']) || empty($store['GeoLocation']['lng'])) continue; ?>
		var latLng = new google.maps.LatLng(<?php echo $store['GeoLocation']['lat']; ?>,<?php echo $store['GeoLocation']['lng']; ?>);
		addMarker(latLng);
	<?php endforeach; ?>

});

function loadPins() {

	var o = {

		url:'/unified/map/load_pins',
		success:function(d) {

			

		}

	};

	$.ajax(o);

}

function clearMarkers () {
	
	if(markers.length>0) {

		for(var a in markers) {

			markers[a].setMap(null);

		}
	
		//clear the shit!
		markers = [];

	}

}

function addMarker ($latLng) {
	
	markers.push(new google.maps.Marker({
		
			position:$latLng,
			animation:google.maps.Animation.DROP,
			map:map,
			icon:"/img/v3/unified/marker.png"


	}));

}

function setZoom($latLng) {

	var miles = arguments[1] || .1;
	
	var radius = 1609.3 * miles;

	var cOptions = {
			center: $latLng,
		    fillOpacity: 0,
		    strokeOpacity:1,
		    map: map,
		    radius: radius /* 20 miles */
	};

	var cir = new google.maps.Circle(cOptions);

	map.fitBounds(cir.getBounds());

}



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
	<div class="row-fluid">
		<div class="span12">
			<?php foreach ($stores as $k => $v): ?>
			<div>
				<h2><?php echo $v['UnifiedStore']['shop_name']; ?></h2>
			</div>
			<?php endforeach ?>
		</div>
	</div>
</div>