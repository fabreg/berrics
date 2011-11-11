<?php 

$this->Html->script(array("https://maps.googleapis.com/maps/api/js?sensor=true"),array("inline"=>false));


?>
<script type='text/javascript'>
var map,geocoder,marker,marker_img = false;
$(document).ready(function() { 

	var lat = new google.maps.LatLng(34.0522342,-118.2436849);
	
	var mapop = {

		zoom:14,
		center:lat,
		mapTypeId: google.maps.MapTypeId.HYBRID
			
	};
	
	geocoder = new google.maps.Geocoder();
	map = new google.maps.Map(document.getElementById("map"),mapop);

	$("#tester").click(function() {
		
		younitedNationsGeocode();
		
	});

	$("#YounitedNationsEntryCityStatePostal").bind('blur',function() { 

		younitedNationsGeocode();

	});

	$("#entry-form label").addClass('red-label-x');
	
	
});

function younitedNationsGeocode() {

	var country = $("#YounitedNationsEntryCountry").val();
	var other = $("#YounitedNationsEntryCityStatePostal").val();

	geocoder.geocode( { 'address': other+" "+country}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {

				if(!marker) {

					marker = new google.maps.Marker();

				} 

				if(!marker_img) {

					marker_img = new google.maps.MarkerImage("/theme/younited-nations-3/img/yn3-pin.png");

					marker.setIcon(marker_img);
					
				}

	          marker.setMap(map); 
	          marker.setPosition(results[0].geometry.location);
			  marker.setDraggable(true);
	       	  map.setCenter(results[0].geometry.location);

				if(other.length>0) {

					 map.setZoom(14);
					
				} else {


					 map.setZoom(4);
					
				}
		       	  
		         
		        $("body").append(results[0].geometry.location.lng()+" : "+results[0].geometry.location.lat());

				$("#YounitedNationsEntryLongitude").val(results[0].geometry.location.lng());
				$("#YounitedNationsEntryLatitude").val(results[0].geometry.location.lat());

		        
		        
	      } else {
		      
	        	alert("Geocode was not successful for the following reason: " + status);
	        
	      }
	});

	
}


</script>
<div id='younited-nations-entry'>
	<div class='entry-form-div'>
		<div class='inner'>
			<div class='container'>
				<div class='container-top'>
					<?php echo $this->Form->create("YounitedNationsEntry",array("url"=>$this->here));?>
					<div class='form-content'>
						<div class='rules'>
							<div class='heading'>RULES</div>
							<p>	
								Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah
							</p>
						</div>
						<div id='entry-form'>
							<div class='form-header'>
								
							</div>
							<div class='inner'>
								<?php 
								
									echo $this->element("younited-nations-3/crew-info-form");
									echo $this->element("younited-nations-3/crew-roster-form");
									//echo $this->element("");
										
								?>
							</div>
						</div>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
	<div></div>
	<div style='clear:both;'></div>
</div>