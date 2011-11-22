<?php 

$this->Html->script(array("https://maps.googleapis.com/maps/api/js?sensor=true"),array("inline"=>false));

?>
<script>
var map,geocoder,marker_img;
var markers = [];
$(document).ready(function() { 
	geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var lat = new google.maps.LatLng(34.0522342,-118.2436849);
	var myOptions = {
		      zoom:2,
		      center: latlng,
		      mapTypeId: google.maps.MapTypeId.HYBRID,
		      center:lat
	};
	map = new google.maps.Map(document.getElementById("map"),myOptions);
	marker_img = new google.maps.MarkerImage("/theme/younited-nations-3/img/vans_pin.png");
	<?php foreach($entries['YounitedNationsEventEntry'] as $k=>$e): ?>

	markers[<?php echo $k; ?>] = new google.maps.Marker({

			
			position:new google.maps.LatLng(<?php echo $e['YounitedNationsPosse']['geo_latitude']; ?>,<?php echo $e['YounitedNationsPosse']['geo_longitude']; ?>)

		});
	markers[<?php echo $k; ?>].setMap(map);
	markers[<?php echo $k; ?>].setIcon(marker_img);
	<?php endforeach;?>
	
});

</script>
<style>

#map {

	height:450px;
	width:100%;
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
<?php 

pr($entries);

?>