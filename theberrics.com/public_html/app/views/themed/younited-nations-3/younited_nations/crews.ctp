<?php 

$this->Html->script(array("https://maps.googleapis.com/maps/api/js?sensor=true"),array("inline"=>false));

?>
<script>
var map,geocoder;
$(document).ready(function() { 
	geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
	var myOptions = {
		      zoom: 4,
		      center: latlng,
		      mapTypeId: google.maps.MapTypeId.HYBRID
	};
	var marker = false;
	map = new google.maps.Map(document.getElementById("map"),myOptions);
	
	

	$("#test-button").click(function() { 


		geocoder.geocode( { 'address': $("#address").val()}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {

					if(!marker) {

						marker = new google.maps.Marker();

					} 

					
					
		       			
			       		
			          marker.setMap(map); 
			          marker.setPosition(results[0].geometry.location);
					  marker.setDraggable(true);
			       	  map.setCenter(results[0].geometry.location);
			          map.setZoom(12);
			        $("body").append(results[0].geometry.location.lng()+" : "+results[0].geometry.location.lat());
			        
		      } else {
		        alert("Geocode was not successful for the following reason: " + status);
		      }
		});
	});
	
});

</script>
<style>

#map {

	height:300px;
	width:300px;
}

</style>
<div>
<?php 

	echo $this->Form->input("address");
	

?>
<input type='button' value='test' id='test-button' />
</div>
<div id='map'>

</div>