<?php 

$country = Arr::countries();


 ?>
<script type="text/javascript">

var geocoder = false;
var map = false;
var startLng = '<?php echo (!empty($this->request->data['GeoLocation']['lng'])) ? $this->request->data['GeoLocation']['lng']:'118.2428';?>';
var startLat = '<?php echo (!empty($this->request->data['GeoLocation']['lat'])) ? $this->request->data['GeoLocation']['lat']:'34.0522';?>';
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


	///////
	//state and country drop downs
	/////

	//get all the opt groups in an object
	$("#UnifiedStoreState optgroup").each(function() { 

		ship_to_states[$(this).attr("label")]=$(this).html();
		
	});


	$("#UnifiedStoreCountryCode").change(function() { 

		shipChangeState();

	});
	//$("#ShippingAddressCountry").change();
	shipChangeState();
	
	

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

var ship_to_states = {};
$(document).ready(function() { 

	
	
	
});


function shipChangeState() {

	var country = $("#UnifiedStoreCountryCode").val();

	//check to see if we have an already selected state or value
	var sel = $("#UnifiedStoreState").val();
	
	if(ship_to_states[country]) {

		
		$("#UnifiedStoreState").html(ship_to_states[country]);
		$("#form-shipping-state-text-div").hide().find('input').attr({"disabled":true});
		$("#form-shipping-state-select-div").show().find('select').attr({"disabled":false});

		//try and set the selected val
		if(sel.length>0) {

			$("#UnifiedStoreState[value="+sel+"]").attr({"selected":"selected"});
			
		}
		
	} else {

		$("#form-shipping-state-select-div").hide().find('select').attr({"disabled":true});
		$("#form-shipping-state-text-div").show().find('input').attr({"disabled":false});
	}
	
}

</script>
<div id="unified-location">
	<h3>Edit Location</h3>
	<div class="row-fluid">
		<div class="span6">
			<?php 
				echo $this->Form->input('address1');
				echo $this->Form->input('address2');
				echo $this->Form->input('city');
				echo $this->Form->input('zip');
				echo $this->Form->input('country_code',array("options"=>$country));
				echo $this->Form->input('state',array("options"=>Arr::states(),"div"=>array("id"=>"form-shipping-state-select-div")));
				echo $this->Form->input("state-text",array("label"=>$l['state'],"name"=>"data[UnifiedStore][state]","div"=>array("id"=>"form-shipping-state-text-div")));
				echo $this->Form->input('phone');

			 ?>
			 <button class="btn btn-info" id='show-on-map-btn' type="button">Show On Map</button>
		</div>
		<div class="span6">
			<div id="map_canvas" style='min-height:500px; width:100%;'></div>
			<div class="well well-small" style='margin-top:10px;'>
				<h3>Geo Location</h3>
				<div class="row-fluid">
					<div class="span4">
						<?php echo $this->Form->input("GeoLocation.lat"); ?>
					</div>
					<div class="span4">
						<?php echo $this->Form->input("GeoLocation.lng"); ?>
					</div>
					<div class="span4">
						<?php if (isset($this->request->data['GeoLocation']['id'])): ?>
							<?php echo $this->Form->input("GeoLocation.id"); ?>		
						<?php endif ?>
						<?php echo $this->Form->input("GeoLocation.model",array("type"=>"hidden","value"=>"UnifiedStore")); ?>
						<?php echo $this->Form->input("GeoLocation.foreign_key",array("type"=>"hidden","value"=>$this->request->data['UnifiedStore']['id'])); ?>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span8">
						<?php echo $this->Form->input("GeoLocation.street_address_formatted"); ?>
					</div>
					<div class="span4"></div>
					
				</div>
			</div>
		</div>
	</div>
</div>