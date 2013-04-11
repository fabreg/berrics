<?php
	$this->Unified->mapJsIncludes();
?>
<script>

//var markersJson = <?php echo json_encode($stores); ?>;
var map,geocoder = false;
var startLng = '<?php echo (!empty($this->request->data['GeoLocation']['lng'])) ? $this->request->data['GeoLocation']['lng']:'-118.2436849';?>';
var startLat = '<?php echo (!empty($this->request->data['GeoLocation']['lat'])) ? $this->request->data['GeoLocation']['lat']:'34.0522342';?>';
var markers = [];
var circle = false;
var centerMarker = false;
var markersJson = <?php echo json_encode($stores); ?>;
var infoWindow = false;

jQuery(document).ready(function($) {
	
	geocoder = new google.maps.Geocoder();

	if(navigator.geolocation) {

		navigator.geolocation.getCurrentPosition(function(p) {

			bootstrapMap(p.coords.latitude,p.coords.longitude);
			shopLatLong(p.coords.latitude,p.coords.longitude,25);

		},function() { });

	} else {

		bootstrapMap(startLat,startLng);

	}

	$(window).bind('resize.map',function() {

		handleScreenResize();

	}).trigger('resize');
	
});

function handleScreenResize() {
	
	var bw = $(window).width(); //browser width
	var bh = $(window).height(); //browser height
	
	var mw = $('#map-row').width(); //map width
	var mh = $("#map-row").height(); //map height
	
	if(bw<=798) {
	
		$("#shop-results").css({"height":"auto"});

	} else {

		$("#shop-results").height(mh);

	}

	

}

function bootstrapMap($lat,$lng) {
		
		var latLng = new google.maps.LatLng($lat, $lng);
 		var mapOptions = {
          center: latLng,
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        if(!map) map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

        setZoom(latLng,25);
	
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

function addMarker ($latLng,$unified_store_id) {
	
	var mark = new google.maps.Marker({
		
			position:$latLng,
			animation:google.maps.Animation.DROP,
			map:map,
			//icon:"/img/v3/unified/marker.png",
			unified_store_id:$unified_store_id
			
	});
	
	google.maps.event.addListener(mark,'click',function() { 
	
		var store = markersJson[mark.unified_store_id];

		if(infoWindow) {

			infoWindow.close();

		}

		infoWindow = new google.maps.InfoWindow({

			"content":store.UnifiedStore.shop_name

		});

		infoWindow.open(map,mark);

	});

	google.maps.event.addListener(mark,'dblclick',function() { 
	
		var store = markersJson[mark.unified_store_id];
	
		map.setZoom(12);

		map.panTo(mark.position);

	});

	markers[mark.unified_store_id]=mark;

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

		//console.log($geo);
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

			$('.shop-result').bind('click',function() { 

				var id = $(this).attr("data-unified-store-id");

				var store = markersJson[id];
				
				map.setZoom(17);

				map.panTo(markers[id].position);

				google.maps.event.trigger(markers[id],'click');

			});


		}
	
	};

	$.ajax(o);

}

function loadAllPins() {

	for(var a in markersJson) {
	
		var latLng = new google.maps.LatLng(markersJson[a].GeoLocation.lat,markersJson[a].GeoLocation.lng);
		addMarker(latLng,markersJson[a].UnifiedStore.id);
		

	}

}

function setSearchMarker($lat,$lng) {

	if(centerMarker) centerMarker.setMap(null);

	//marker options
	var o = {
	
		

	};

	centerMarker = new google.maps.Marker(o);

}

function handleMarkerClick($marker) {

	

}


</script>
<style>
	body {

		background-image:none;
		background-color:#fff;
		font-family: Helvetica, Arial, "Lucida Grande", sans-serif; 

	}

	#unified-map {

		padding:10px;
	

	}

	.shop-result {
	
		border-top:2px solid #000;
		padding:4px;
		
	}

	.shop-result:hover {
	
		background-color:#e9e9e9;
		cursor: pointer;
	}

	.shop-result .name {

		font-size:15px;
		font-weight: bold;
		margin-bottom:3px;

	}
	
	.shop-result .address {

		font-size:10px;
		line-height: 13px;
		padding-left:10px;
	}

	#shop-results {

		overflow:auto;
		background-color:#fff;

	}

	#results-col {

		position:relative;

	}

	#map-container {

		margin-left:5px;

	}

	#map_canvas {

		min-height:500px;

	}
	
	.distance-div .distance-label {
		font-size:12px;
		width:100px;
		padding:5px;
		background-color:#000;
		line-height:18px;
		text-align:center;
		color:#fff;
		margin-left:10px;
		margin-top:5px;
	}


</style>
<?php 

	$miles = array("5"=>"5 Miles","10"=>"10 Miles");

	for($i=25;$i<=100;$i+=25) {

		$miles[$i] = $i." Miles";

	}

 ?>
<div id="unified-map">
	<div class="row-fluid" id='map-row'>
		<div class="span3" id='results-col'>
			 <div id="shop-results">
			 	
			 </div>
		</div>
		<div class="span9 pull-right" id='map-container'>
			<div class="map-search-div">
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
			</div>
			<div id="map_canvas" ></div>
		</div>
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