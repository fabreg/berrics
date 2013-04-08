<?php

$this->Unified->mapJsIncludes();


?>
<script>
//var markersJson = <?php echo json_encode($stores); ?>;
var map,geocoder = null;
var startLng = '<?php echo (!empty($this->request->data['GeoLocation']['lng'])) ? $this->request->data['GeoLocation']['lng']:'-118.2436849';?>';
var startLat = '<?php echo (!empty($this->request->data['GeoLocation']['lat'])) ? $this->request->data['GeoLocation']['lat']:'34.0522342';?>';
var markers = [];
var circle = false;
jQuery(document).ready(function($) {

	bootstrapMap(startLat,startLng);

	//drop an initial pin
	
	geocoder = new google.maps.Geocoder();
	
	<?php foreach($stores as $store): ?>
		<?php if(empty($store['GeoLocation']['lat']) || empty($store['GeoLocation']['lng'])) continue; ?>
		var latLng = new google.maps.LatLng(<?php echo $store['GeoLocation']['lat']; ?>,<?php echo $store['GeoLocation']['lng']; ?>);
		addMarker(latLng);
	<?php endforeach; ?>


});

function bootstrapMap($lat,$lng) {
		
		var latLng = new google.maps.LatLng($lat, $lng);
 		var mapOptions = {
          center: latLng,
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);

        setZoom(latLng,10);
	
		
		loadAllPins();

	//zip search form

	$("#StoreSearchForm").submit(function() { 

		zipSearch($("#StoreSearchQuery").val(),$("#StoreSearchMiles").val());

		return false;

	});


}

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
			map:map
			//icon:"/img/v3/unified/marker.png"


	}));

}

function setZoom($latLng) {

	var miles = arguments[1] || 10;
	
	var radius = 1609.34 * miles;

	var cOptions = {
			center: $latLng,
		    fillOpacity: 0,
		    strokeOpacity:.5,
		    map: map,
		    radius: radius ,
		    strokeColor:"red"
	};
	
	if(circle) circle.setMap(null);

	circle = new google.maps.Circle(cOptions);

	map.fitBounds(circle.getBounds());

}

function zipSearch($zip,$radius) {

	var r = {};

	r.address = $zip;

	geocoder.geocode(r,function($geo,$res) { 
	
		map.setCenter($geo[0].geometry.location);
		setZoom($geo[0].geometry.location,$radius);
		//map.setZoom(19);
		//clearMarkers();
		//addMarker($geo[0].geometry.location);

		//set the lat and long fields
		//$("#GeoLocationLat").val($geo[0].geometry.location.lat());
		//$("#GeoLocationLng").val($geo[0].geometry.location.lng());
		//$("#GeoLocationStreetAddressFormatted").val($geo[0].formatted_address);

		console.log($geo);
		shopLatLong($geo[0].geometry.location.lat(),$geo[0].geometry.location.lng(),$radius);

	});

}

function shopLatLong($lat,$lng,$distance) {

	var o = {
		"type":"post",
		"url":"/unified/map/search_shops_geo",
		"data":{

			data:{

				"GeoLocation":{

					"lat":$lat,
					"lng":$lng,
					"distance":$distance

				}

			}

		},
		success:function(d) { 
		
			$("#shop-results").html(d);

		}
	
	};

	$.ajax(o);

}

function loadAllPins() {

	var o = {
		
		url:"/unified/map/pins_json",
		success:function(d) {

			

		}


	};
	
	$.ajax(o);

}


</script>
<style>
	body {

		background-image:none;
		background-color:#fff;
		font-family: Helvetica, Arial, "Lucida Grande", sans-serif; 

	}
	.shop-result {


	}

	.shop-result .name {

		font-size:15px;
		
	}
</style>
<?php 

	$miles = array("5"=>"5 Miles","10"=>"10 Miles");

	for($i=25;$i<=100;$i+=25) {

		$miles[$i] = $i." Miles";

	}

 ?>
<div id="unified-map">
	<div class="row-fluid">
		<div class="span3">
			<?php 
				echo $this->Form->create('StoreSearch',array(
					"id"=>'StoreSearchForm',
					"url"=>$this->request->here
				));
			 ?>
			 <?php echo $this->Form->input("query",array("label"=>false,"placeholder"=>"Zip/Postal Code or Address")); ?>
			 <div class="row-fluid">
			 	<div class="span6">
			 		<?php echo $this->Form->input("miles",array("options"=>$miles,"label"=>false)); ?>
			 	</div>
			 	<div class="span6">
			 		<button class="btn btn-inverse">Search</button>
			 	</div>
			 </div>
			 <?php echo $this->Form->end(); ?>
			 <div id="shop-results">
			 	
			 </div>
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