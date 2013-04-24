<?php

$this->Unified->storeProfileIncludes();
$this->Unified->mapJsIncludes();
?>
<script>


var geocoder = false;
var map = false;
var startLng = '<?php echo $store['GeoLocation']['long']; ?>';
var startLat = '<?php echo $store['GeoLocation']['lat']; ?>';
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
	addMarker(latLng);
	
	geocoder = new google.maps.Geocoder();
	//bind some of the buttons

	$("#show-on-map-btn").bind('click',function(e) { 

		showAddressOnMap();

	});
	
	

});

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
			map:map


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



function showAddressOnMap () {
	
	var a = $("#UnifiedStoreAddress1").val();

	a += " "+$("#UnifiedStoreAddress2").val();

	a += " "+$("#UnifiedStoreCity").val();

	a += " "+$("#UnifiedStoreState").val();
	
	a += " "+$("#UnifiedStoreZip").val();
	
	var r = {};

	r.address = a;
	
	

	geocoder.geocode(r,function($geo,$res) { 
	
		map.setCenter($geo[0].geometry.location);
		setZoom($geo[0].geometry.location);
		//map.setZoom(19);
		clearMarkers();
		addMarker($geo[0].geometry.location);

		//set the lat and long fields
		$("#GeoLocationLat").val($geo[0].geometry.location.lat());
		$("#GeoLocationLng").val($geo[0].geometry.location.lng());
		$("#GeoLocationStreetAddressFormatted").val($geo[0].formatted_address);

		console.log($geo);

	});

}	
</script>
<?php echo $this->element("store_profile/hero-unit") ?>
<div id="map_canvas" style='height:350px;'>
	
</div>

<?php 

pr($store);

?>


